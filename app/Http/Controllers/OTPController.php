<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use Illuminate\Http\Request;
use OTPHP\TOTP;

class OTPController extends Controller
{
    public function verify(Request $request)
    {
        if (!$request->user()->has('otp')) {
            return ['message' => '2FA not enabled'];
        }

        $sanitized = $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $otp = $request->user->otp;

        $totp= TOTP::create($otp->key);

        $result = $totp->verify($sanitized);

        return ['message' => $result ? 'success' : 'failed'];
    }

    public function enable(Request $request)
    {
        $sanitized = $request->validate([
            'key' => 'required|max:128|min:64',
            'otp' => 'required|digits:6'
        ]);

        $totp = TOTP::create($sanitized['key']);
        $result = $totp->verify($sanitized['otp']);

        if ($result) {
            $otp = new OTP();
            $otp->key = $sanitized['key'];
            $request->user()->otp()->save($otp);
            return ['message' => 'success'];
        } else {

            return response(['message' => 'failed'], 403);
        }

    }
}
