<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
    /**
     * Show metrics
     */
    public function index() {
        $activities_count = Activity::all()->count();
        $users_count = User::all()->count();

        return response()->json([
            'activities_count' => $activities_count,
            'users_count' => $users_count
        ]);
    }
}
