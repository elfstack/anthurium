<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile(Request $request)
    {
        return view('user.profile', [
            'user' => $request->user(),
        ]);
    }

    public function security(Request $request)
    {
        $user = $request->user();

        return view('user.security', [
            'recentLogins' => $user->recentLogins,
        ]);
    }
}
