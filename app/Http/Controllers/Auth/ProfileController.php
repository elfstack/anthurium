<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ParagonIE\ConstantTime\Base32;
use OTPHP\TOTP;

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

    /**
     * TODO: 2FA Authentication
     *
     */
    public function security(Request $request)
    {
        $user = $request->user();

        $secret = '';
        $uri = '';

        if (true) {
            $secret = trim(Base32::encodeUpper(random_bytes(64)), '=');
            $otp = TOTP::create($secret);
            $uri = 'otpauth://totp/'.env('APP_NAME').':'.$user->email.'?secret='.$secret.'&issuer='.env('APP_NAME');
        }

        return view('user.security', [
            'recentLogins' => $user->recentLogins,
            'secret' => $secret,
            'uri' => $uri
        ]);
    }
}
