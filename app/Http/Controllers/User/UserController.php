<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Configuration;
use App\Models\DataCollection;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\User;
use App\Models\UserGroup;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new user
     *
     * This methods stores a newly created user to the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'unique:users'
            ],
            'password' => 'min:6|required'
        ]);

        $sanitized = $validator->validate();
        $sanitized['password'] = Hash::make($sanitized['password']);

        $user = new User;
        $user->fill($sanitized)->setUserGroup();
        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        // TODO: privacy: display email or not
        $user->load(['userGroup']);
        $user->makeHidden(['updated_at', 'email_verified_at']);
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $sanitized = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admin_users')->ignore($user->id)
            ],
            'password' => 'sometimes|min:6',
            'roles' => 'array|required'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        $user->update($sanitized);

        return response()->json([
            'user' => $user
        ]);
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
        $user->load('userGroup');

        // TODO: only add this property for guest userGroup
        $user->is_member_application_form_filled = $this->isMemberApplicationFormFilled($user);

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

    public function isMemberApplicationFormFilled (User $user) {
        $dataCollection = DataCollection::memberApplicationForm();

        if ($dataCollection->response()->where('user_id', $user->id)->exists()) {
            return true;
        }

        return false;
    }
}
