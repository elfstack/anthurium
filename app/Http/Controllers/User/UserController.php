<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Configuration;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\User;
use App\Utils\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $registrationFormId = null;

        if (Configuration::getConfig('registration.form')) {
            $registrationFormId = Configuration::getConfig('registration.form_id');
        }

        $hasRegistrationFormId = function () {
            return isset($registrationFormId);
        };

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'unique:users'
            ],
            'password' => 'min:6|required',
            // 'roles' => 'array|required'
        ]);

        $validator->sometimes('answers.*.question_id', [
            'required',
            'unique',
            'integer',
            Rule::exists('form_questions', 'id')->where(function ($query) use ($registrationFormId) {
                $query->where('form_id', $registrationFormId);
            })
        ], $hasRegistrationFormId);

        $sanitized = $validator->validate();

        // TODO: validate answer
        $sanitized['password'] = Hash::make($sanitized['password']);

        DB::beginTransaction();
        try {
            $user = User::create($sanitized);
            // TODO: move to FormAnswer
            if (isset($registrationFormId)) {
                $answersWrapper = new FormAnswer();
                $answersWrapper->answerer()->associate($user);
                $answersWrapper->form()->associate(Form::find($registrationFormId));
                $answers = collect($request->input('answers'))->map(function ($answer) {
                    return [
                        'form_question_id' => $answer['question_id'],
                        'answer' => $answer['answer']
                    ];
                });
                $answersWrapper->save();
                $answersWrapper->answers()->createMany($answers);
            }
            DB::commit();
        } catch (\Exception $e) {
            abort(500, $e);
            DB::rollBack();
        }

        return [
            'user' => $user
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param AdminUser $adminUser
     * @return array
     */
    public function show(AdminUser $adminUser)
    {
        $adminUser->roles = $adminUser->roles()->pluck('id');

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AdminUser $adminUser
     * @return array
     */
    public function update(Request $request, AdminUser $adminUser)
    {
        $sanitized = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admin_users')->ignore($adminUser->id)
            ],
            'password' => 'sometimes|min:6',
            'roles' => 'array|required'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        $adminUser->roles()->sync($sanitized['roles']);

        $adminUser->update($sanitized);

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AdminUser $adminUser
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(AdminUser $adminUser)
    {
        $adminUser->delete();
        return response()->noContent();
    }

    /**
     * Retrieve current logged in admin_user
     *
     * @param Request $request
     * @return array
     */
    public function current(Request $request)
    {
        $user = $request->user();

        $user->avatar_url = $user->getFirstMediaUrl('avatars', 'avatar');

        // $user->roles = $adminUser->roles()->pluck('name');

        return [
            'user' => $user
        ];
    }

    /**
     * Update current logged in admin_user
     * @param Request $request
     * @param AdminUser $adminUser
     * @return array
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function updateCurrent(Request $request) {
        $adminUser = $request->user();

        $sanitized = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admin_users')->ignore($adminUser->id)
            ],
            'avatar_path' => 'sometimes',
            'password' => 'sometimes|min:6'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        if ($request->has('avatar_path')) {
            $adminUser->addMediaFromDisk($request->input('avatar_path'))
                ->toMediaCollection('avatars');
        }

        $adminUser->update($sanitized);

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * List all activities of current user
     * @param Request $request
     */
    public function currentActivities(Request $request) {
        $user = $request->user();

        $activities = $user->participatedActivities();
        // TODO: filtering
        // TODO: listing

        Listing::fromQuery($activities)
            ->attachSearching(['title'])
            ->attachSorting(['title', 'starts_at', 'ends_at']);
    }
}
