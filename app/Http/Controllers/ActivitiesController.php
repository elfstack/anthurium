<?php

namespace App\Http\Controllers;

use App\Exceptions\UserAlreadyCheckedInException;
use App\Exceptions\UserNotParticipatedException;
use App\Http\Requests\Activity\IndexActivity;
use App\Models\Activity;
use App\User;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivitiesController extends Controller
{

    public function index(IndexActivity $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Activity::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'starts_at', 'ends_at', 'quota'],

            // set columns to searchIn
            ['id', 'name', 'content'],

            function ($query) use ($request) {
                if ($request->has('status'))
                {
                    $time = $request->input('status');

                    if ($time == 'past')
                    {
                        $query->where('ends_at', '<', Carbon::now());
                    }
                    else
                    {
                        $query->where('ends_at', '>', Carbon::now());

                        if ($time == 'upcoming')
                        {
                            $query->where('starts_at', '>', Carbon::now());
                        }
                        else if ($time == 'ongoing')
                        {
                            $query->where('starts_at', '<', Carbon::now());
                        }
                    }
                }
            }
        );

        if ($request->has('bulk')) {
            return [
                'bulkItems' => $data->pluck('id')
            ];
        }
        return ['data' => $data];
    }

    public function enroll(Activity $activity, Request $request) {
        $status = $request->user()->enroll($activity);

        return [
            'enrolled' => $status
        ];
    }

    public function show(Activity $activity, Request $request) {
        if (!$activity->is_public) {
            $user = $request->user();

            if (!$user) {
                abort('403', 'Forbidden');
            }

            if ($request->has('token')) {
                $this->checkin($activity, $user, $request->input('token'));
            };

            return view('activity.show', [
                'activity' => $activity,
                'user_is_enrolled' => $user ? $user->isParticipant($activity) : false
            ]);

        } else {
            // TODO: guest is participated
            if ($request->has('token')) {
                // TODO: guest way to checkin
            }

            // TODO: unenrolled
            return view('activity.show', [
                'activity' => $activity,
                'user_is_enrolled' => false
            ]);
        }
    }

    /**
     * Check In
     *
     * If user visit the activity with a valid token, check in will be
     * proceed.
     *
     * @return void
     */
    public function checkin(Request $request, Activity $activity) {
        // TODO: disable checkin for past activities

        if ($request->hasValidSignature()) {
            try {
                $request->user()->checkin($activity);
            } catch (UserAlreadyCheckedInException $e) {
                return 'already checked in';
            } catch (UserNotParticipatedException $e) {
                return 'NotParticipated';
            }
        } else {
            // TODO: abort should be replaced with better error message
            abort(400, 'Incorrect token or expired');
        }
    }

    public function checkout(Activity $activity, Request $request) {
        return $request->user()->checkout($activity);
    }
}
