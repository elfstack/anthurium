<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function update(Request $request, Participation $participation)
    {
        $sanitized = $request->validate([
            'status' => 'required|in:rejected,approved,attended,left,cancelled'
        ]);

        switch ($sanitized['status']) {
            case 'rejected':
                $participation->reject();
                return;
            case 'approved':
                $participation->approve();
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
}
