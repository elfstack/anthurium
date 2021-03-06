<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Models\Participation;
use App\Utils\Listing;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ParticipationController extends Controller
{
    /**
     * Get activities user participated
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function index(Request $request, User $user)
    {
        $activities = $user->participatedActivities()
            ->withPivot(['id', 'arrived_at', 'left_at', 'approved_at', 'rejected_at', 'cancelled_at'])
            ->withTimestamps();

        if ($request->query('is_current')) {
            // TODO: filter current participated activities
            $now = Carbon::now();
            $activities->whereDate('ends_at', '>', $now);
            $activities->where('is_published', true);
        }

        $result = Listing::fromQuery($activities)
            ->setColumns(['activities.id', 'name', 'starts_at', 'ends_at', 'quota'])
            ->get($request);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Participation $participation
     * @return JsonResponse
     */
    public function show(Participation $participation)
    {
        $participation->load(['activity', 'participant']);

        return response()->json([
            'participation' => $participation
        ]);
    }

    /**
     * Drop enrollment
     * TODO: a better drop method may be implemented
     *
     * @param Participation $participation
     * @return JsonResponse
     */
    public function destroy(Participation $participation)
    {
        if ($participation->getParticipationStatusAttribute() != "pending") {
            abort('500', 'Your request has already been processed');
        }

        $participation->delete();

        return response()->json([
            'message' => 'dropped'
        ]);
    }


    /**
     * Check out participant
     * TODO: add permission on this api
     * TODO: add detailed message on this api
     * TODO: change url signature
     *
     * @param Request $request
     * @param Activity $activity
     * @param Participation $participation
     * @return JsonResponse
     */
    public function checkOut(Request $request, Activity $activity, Participation $participation)
    {
        if ($request->user('api')) {
            $participant = $request->user('api');
        } else if ($request->hasValidSignature()) {
            // TODO: can checkout guest
            throw new RuntimeException('not implemented');
        } else {
            abort(403);
        }

        if (!$participant->equals($participation->participant)) {
            abort(401);
        }

        try {
            $participation->pivotParent = $activity;
            $participation->checkOut();
        } catch (Exception $e) {
            abort(500, 'error checking out');
        }

        return response()->json([
            'message' => 'checked out',
            'left_at' => $participation->left_at
        ]);
    }
}
