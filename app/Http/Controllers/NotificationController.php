<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function notifications(Request $request)
    {
        $activitiesParticipatedOngoing = $request->user()
            ->activitiesParticipated()
            ->where('starts_at', '<', Carbon::now())
            ->where('ends_at', '>', Carbon::now())
            ->get();

        $activitiesParticipatedUpcoming = $request->user()
            ->activitiesParticipated()
            ->where('starts_at', '>', Carbon::now())
            ->get();

        return view('dashboard', [
            'activitiesParticipatedOngoing' => $activitiesParticipatedOngoing,
            'activitiesParticipatedUpcoming' => $activitiesParticipatedUpcoming
        ]);
    }

}
