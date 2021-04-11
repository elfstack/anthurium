<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request) : JsonResponse
    {
        $activities = Listing::create(Activity::class)
            ->attachFiltering(['type'])
            ->attachSearching(['name'])
            ->attachSorting(['starts_at', 'ends_at', 'created_at', 'published_at'])
            ->modifyQuery(function (Builder $query) {
                $this->modifyIndexQuery($query);
            })
            ->get($request);

        return response()->json($activities);
    }

    public function show(Activity $activity) : JsonResponse
    {
        $activity->load('userGroups');
        $activity->status = $activity->getStatus();

        return response()->json([
            'activity' => $activity
        ]);
    }

    public function store(Request $request) : JsonResponse
    {
        $sanitized = $request->validate([
            'name' => 'required|string',
            'quota' => 'sometimes|integer',
            'starts_at' => 'sometimes|date',
            'ends_at' => 'sometimes|date',
        ]);

        return response()->json([
            'activity' => Activity::create($sanitized)
        ]);
    }

    public function update(Request $request, Activity $activity) : JsonResponse
    {
        $sanitized = $request->validate([
            'name' => 'sometimes|string',
            'content' => 'sometimes|string',
            'starts_at' => 'sometimes|date|required',
            'ends_at' => 'sometimes|date|required',
            'is_published' => 'sometimes|boolean',
            'quota' => 'sometimes|integer',
            'user_groups' => 'sometimes|array|min:1',
            'user_groups.*' => 'integer'
        ]);

        if (isset($sanitized['user_groups'])) {
            $activity->userGroups()->sync($sanitized['user_groups']);
        }

        // check for publish
        if (isset($sanitized['is_published']) && $sanitized['is_published']) {
            if ($activity->userGroups()->count() == 0) {
                abort(500, 'Activity must have at least 1 user group');
            }

            // check timing
        }

        $activity->update($sanitized);

        $activityDiff = $activity->getChanges();
        $activityDiff['status'] = $activity->getStatus();

        return response()->json([
            'activity' => $activityDiff
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
            ->with('participant', 'participant.userGroup')->getQuery();

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
                'pending' => $activity->participations()->whereNull('approved_at')->whereNull('rejected_at')->count(),
                'admitted' => $admitted,
                'rejected' => $activity->participations()->whereNotNull('rejected_at')->count(),
                'attended' => $attended,
                'unattended' => $admitted - $attended,
                'left' => $activity->participations()->whereNotNull('left_at')->count(),
                'cancelled' => $activity->participations()->whereNotNull('cancelled_at')->count()
            ]
        ]);
    }

    public function dataCollection(Activity $activity) {
        return response()->json([
            'data_collection' => $activity->dataCollection()
        ]);
    }

    private function modifyIndexQuery(Builder $query)
    {
        $draft = DB::table('activities')
            ->where('is_published', false)
            ->select(['*'])
            ->addSelect(DB::raw('\'draft\' as status'))
            ->addSelect(DB::raw('1 as statusN'));

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
            ->union($draft)
            ->union($upcoming)
            ->union($past)
            ->orderby('statusN', 'asc');
    }
}
