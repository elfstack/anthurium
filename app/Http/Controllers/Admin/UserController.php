<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\UserGroup;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $result = Listing::create(User::class)
                         ->attachSorting(['id', 'pending_actions_count'])
                         ->modifyQuery(function ($query) {
                             $query->with('userGroup:id,name');

                             // TODO: make this optional
                             $query->withCount(['pendingActions']);
                         })
                         ->get($request);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
            'user_group.id' => 'required|in:user_groups'
        ]);

        $sanitized['password'] = Hash::make($sanitized['password']);

        $user = User::create($sanitized);

        return request()->json([
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
        $user->load('userGroup', 'pendingActions');

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
            'name' => 'sometimes',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'min:6|sometimes',
            'user_group.id' => 'sometimes|exists:user_groups,id'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        $user->update($sanitized);

        if ($sanitized['user_group']['id']) {
            $user->userGroup()->associate(UserGroup::find($sanitized['user_group']['id']));
            $user->save();
        }

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    /**
     * Get activities user participated
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function participations(Request $request, User $user)
    {
        $activities = $user->participatedActivities()
                           ->withPivot(['arrived_at', 'left_at', 'approved_at', 'rejected_at', 'cancelled_at'])
                           ->withTimestamps();

        $result = Listing::fromQuery($activities)
            ->setColumns(['activities.id', 'name', 'starts_at', 'ends_at'])
            ->get($request);

        return response()->json($result);
    }

    /**
     * TODO: Get participation stats
     *
     * @param User $user
     * @return JsonResponse
     */
    public function participation_stats(User $user)
    {
        return response()->json([
            'activity_hours' => 0,
            'activities_applied' => $user->participatedActivities()->count(),
            'activities_admitted' => $user->participatedActivities()->count(),
            'activities_attended' => $user->participatedActivities()->count()
        ]);
    }
}
