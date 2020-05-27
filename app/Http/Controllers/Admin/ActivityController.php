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
    public function index (Request $request) : JsonResponse
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
        $activity->status = $activity->getStatus();

        return response()->json([
            'activity' => $activity
        ]);
    }

    public function store(Activity $activity) : JsonResponse
    {
        return response()->json([
            'activity' => Activity::create()
        ]);
    }

    public function update(Request $request, Activity $activity) : JsonResponse
    {
        $sanitized = $request->validate([
            'name' => 'sometimes|string',
            'content' => 'sometimes|string',
            'starts_at' => 'sometimes|date',
            'ends_at' => 'sometimes|date',
            'is_published' => 'sometimes|boolean',
        ]);

        $activity->update($sanitized);

        $activityDiff = $activity->getChanges();
        $activityDiff['status'] = $activity->getStatus();

        return response()->json([
            'activity' => $activityDiff
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
