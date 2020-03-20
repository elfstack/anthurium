<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class DashboardController extends Controller
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
    public function index(Request $request)
    {
        $activitiesParticipatedOngoing = $request->user()
            ->activitiesParticipated()
            ->whereDate('starts_at', '<', Carbon::now())
            ->whereDate('ends_at', '>', Carbon::now())
            ->get();

        $activitiesParticipatedUpcoming = $request->user()
            ->activitiesParticipated()
            ->whereDate('starts_at', '>', Carbon::now())
            ->get();

        return view('dashboard', [
            'activitiesParticipatedOngoing' => $activitiesParticipatedOngoing,
            'activitiesParticipatedUpcoming' => $activitiesParticipatedUpcoming
        ]);
    }

}
