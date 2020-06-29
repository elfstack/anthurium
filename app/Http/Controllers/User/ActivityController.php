<?php

namespace App\Http\Controllers\User;

use App\Models\Activity;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Participation;
use App\Utils\Listing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * List activities
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function index (Request $request) : JsonResponse
    {
        $activities = Listing::create(Activity::class)
            ->attachFiltering(['type'])
            ->attachSearching(['name', 'content'])
            ->attachSorting(['starts_at', 'ends_at', 'created_at', 'published_at'])
            ->modifyQuery(function (Builder $query) {
                $this->modifyIndexQuery($query);
            })
            ->get($request);

        return response()->json($activities);
    }

    /**
     * Get activity
     *
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function show(Request $request, Activity $activity) : JsonResponse
    {
        $activity->status = $activity->getStatus();

        if ($request->user()) {
            $activity->is_enrolled = $request->user()->isParticipant($activity);
        }

        return response()->json([
            'activity' => $activity
        ]);
    }

    /**
     * List all participants
     *
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function participants(Request $request, Activity $activity) {
        $query = $activity->participations()
            ->with('participant')->getQuery();

        $listing = Listing::fromQuery($query)
            ->attachSorting(['created_at'])
            ->get($request);

        return response()->json($listing);
    }

    public function statistics(Activity $activity) {
        $attended =  $activity->participations()->whereNotNull('arrived_at')->count();
        $admitted = $activity->participations()->whereNotNull('approved_at')->count();

        return response()->json([
            'statistics' => [
                'quota' => $activity->quota,
                'applicant' => $activity->participations()->count(),
                'admitted' => $admitted,
                'rejected' => $activity->participations()->whereNotNull('rejected_at')->count(),
                'attended' => $attended,
                'unattended' => $admitted - $attended,
                'left' => $activity->participations()->whereNotNull('left_at')->count(),
                'cancelled' => $activity->participations()->whereNotNull('cancelled_at')->count()
            ]
        ]);
    }

    private function modifyIndexQuery(Builder $query)
    {
        $upcoming = DB::table('activities')
            ->where('is_published', true)
            ->where('starts_at','>' ,Carbon::now())
            ->select(['*'])
            ->addSelect(DB::raw('\'upcoming\' as status'))
            ->addSelect(DB::raw('2 as statusN'))
            ->orderby('starts_at', 'desc');

        $past = DB::table('activities')
            ->where('is_published', true)
            ->where('ends_at','<', Carbon::now())
            ->select(['*'])
            ->addSelect(DB::raw('\'past\' as status'))
            ->addSelect(DB::raw('3 as statusN'))
            ->orderby('starts_at', 'desc');

        $query->where('is_published', true)
            ->where('starts_at','<', Carbon::now())
            ->where('ends_at', '>', Carbon::now())
            ->select(['*'])
            ->addSelect(DB::raw('\'ongoing\' as status'))
            ->addSelect(DB::raw('0 as statusN'))
            ->orderby('starts_at', 'desc')
            ->union($upcoming)
            ->union($past)
            ->orderby('statusN', 'asc');
    }

    /**
     * Enroll to activity
     *
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function enroll(Request $request, Activity $activity)
    {
        if ($request->user('api')) {
            $request->user('api')->participate($activity);
            return response()->json([
                'message' => 'enrolled'
            ]);
        }

            // create or find guest
        $sanitized = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $guest = Guest::where('email', $request->input('email'))
                      ->updateOrCreate($sanitized);

        // TODO: check if email already registered
        // TODO: if registered, redirect to login page

        // TODO: send verification email
        $guest->sendEmailEnrollVerificationNotification($activity);

        return response()->json([
            'message' => 'email-sent'
        ]);
    }

    /**
     * Enroll the guest
     *
     * @param Request $request
     * @param Guest $guest
     * @param Activity $activity
     * @return JsonResponse
     */
    public function guestEnroll(Request $request, Guest $guest, Activity $activity)
    {
        if (!$request->hasValidSignature()) {
            // TODO: return a view
            abort(401);
        }

        $guest->participate($activity);

        return response()->json([
            'message' => 'enrolled'
        ]);
    }

    /**
     * Check out participant
     * TODO: add permission on this api
     * TODO: add detailed message on this api
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
            throw new \RuntimeException('not implemented');
        } else {
            abort(403);
        }

        if (!$participant->equals($participation->participant)) {
            abort(401);
        }

        try {
            $participation->pivotParent = $activity;
            $participation->checkOut();
        } catch (\Exception $e) {
            abort(500, 'error checking out');
        }

        return response()->json([
            'message' => 'checked out',
            'left_at' => $participation->left_at
        ]);
    }
}
