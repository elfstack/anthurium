<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Action;
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
     * Retrieve current logged in user
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
        // $user->is_member_application_form_filled = $this->hasPendingMemberApplication($user);

        // $user->roles = $adminUser->roles()->pluck('name');

        return [
            'user' => $user
        ];
    }

    /**
     * Update current logged in user
     * @param Request $request
     * @return array
     */
    public function updateCurrent(Request $request) {
        $user = $request->user();

        $sanitized = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'avatar_path' => 'sometimes',
            'password' => 'sometimes|min:6'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        if ($request->has('avatar_path')) {
            $user->addMediaFromDisk($request->input('avatar_path'))
                ->toMediaCollection('avatars');
        }

        $user->update($sanitized);

        return [
            'user' => $user
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

    /**
     * @deprecated
     *
     * @param User $user
     * @return bool
     */
    public function hasPendingMemberApplication(User $user) {
        $hasMemberApplicationAction = $user->actions()
                       ->where('type', 'member-application')
                       ->where('step', '!=', 0)
                       ->exists();

        if ($hasMemberApplicationAction) {
            return true;
        }

        return false;
    }
}
