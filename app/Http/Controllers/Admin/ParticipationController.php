<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Participation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function update(Request $request, Participation $participation)
    {
        $sanitized = $request->validate([
            'status' => 'required|in:rejected,admitted,attended,left,cancelled'
        ]);

        // TODO: refactor

        switch ($sanitized['status']) {
            case 'rejected':
                $participation->reject();
                return;
            case 'admitted':
                $participation->admit();
                return;
            case 'attended':
                $participation->checkIn();
                return;
            case 'left':
                $participation->checkOut();
                return;
            case 'cancelled':
                $participation->cancel();
                return;
        }

        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Get participant's stats
     *
     * @param Participant $participant
     * @return JsonResponse
     */
    public function statistics(Participant $participant)
    {
        return response()->json([
            'duration' => '',// TODO: calculate duration,
            'enrolled_activities' => '',
            'accepted_activities' => '',
            'attended_activities' => ''
        ]);
    }

    /**
     * Check in participant using otp
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkInParticipant(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'string|required'
        ]);

        $otp = unserialize($validated['otp']);

        $check = array_key_exists('id', $otp) &&
        array_key_exists('expires', $otp) &&
        array_key_exists('signature', $otp);

        $check = $check && Carbon::createFromTimestamp($otp['expires'])->isFuture();
        $signature = hash_hmac('sha256', serialize(['id' => $otp['id'], 'expires' => $otp['expires']]), getenv('APP_KEY'));
        $check = $check && hash_equals($signature, $otp['signature']);

        if (!$check) {
            abort(403, 'invalid otp provided');
        }

        $participation = Participation::find($otp->id);
        $participation->checkIn();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
