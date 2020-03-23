<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function settings(Request $request)
    {
        return view('user.settings', [
            'user' => $request->user(),
        ]);
    }
}
