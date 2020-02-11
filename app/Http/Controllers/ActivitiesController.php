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

class ActivitiesController extends Controller
{
    public function show(Activity $activity) {
        return view('activity.show', [
            'activity' => $activity
        ]);
    }
}
