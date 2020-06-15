<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\User;
use App\Utils\Listing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        $sanitized = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'unique:users'
            ],
            'password' => 'min:6|required',
            'roles' => 'array|required'
        ]);

        $sanitized['password'] = Hash::make($sanitized['password']);

        $user = User::create($sanitized);
        // $user->roles()->sync($sanitized['roles']);

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
}
