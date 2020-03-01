<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\VolunteerInfo;
use App\Models\Activity;

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
    public function index()
    {
        return view('admin.dashboard', [
            'volunteer' => [
                'total' => VolunteerInfo::count()
            ],
            'activity' => [
                'total' => Activity::count(),
            ],
            'budget' => [
                'annual' => 128200,
                'quarter' => [
                    [ 'quarter' => 'Q1', 'budget' => 36000 ],
                    [ 'quarter' => 'Q2', 'budget' => 25000 ],
                    [ 'quarter' => 'Q3', 'budget' => 14751],
                    [ 'quarter' => 'Q4', 'budget' => 42123 ]
                ]
            ],
            'article' => [
                'posts' => 50,
                'draft' => 10,
                'unread_comments' => 12,
            ]
        ]);
    }

}
