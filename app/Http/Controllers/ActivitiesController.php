<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Participant;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Http\Requests\Activity\IndexActivity;

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
                        $query->whereDate('ends_at', '<', Carbon::now());
                    } 
                    else
                    {
                        $query->whereDate('ends_at', '>', Carbon::now());

                        if ($time == 'upcoming')
                        {
                            $query->whereDate('starts_at', '>', Carbon::now());
                        }
                        else if ($time == 'ongoing') 
                        {
                            $query->whereDate('starts_at', '<', Carbon::now());
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

    public function show(Activity $activity) {
        return view('activity.show', [
            'activity' => $activity
        ]);
    }
}
