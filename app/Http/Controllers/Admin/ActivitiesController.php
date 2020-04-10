<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Activity\BulkDestroyActivity;
use App\Http\Requests\Admin\Activity\DestroyActivity;
use App\Http\Requests\Admin\Activity\IndexActivity;
use App\Http\Requests\Admin\Participant\IndexParticipant;
use App\Http\Requests\Admin\Activity\StoreActivity;
use App\Http\Requests\Admin\Activity\UpdateActivity;
use App\Models\Activity;
use App\Models\Participant;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;
use OTPHP\TOTP;

class ActivitiesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexActivity $request
     * @return array|Factory|View
     */
    public function index(IndexActivity $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Activity::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            // ['id', 'name', 'starts_at', 'ends_at', 'quota'],
            ['*'],

            // set columns to searchIn
            ['id', 'name', 'content'],

            function ($query) {


                $upcoming = DB::table('activities')
                    ->where('starts_at','>', Carbon::now())
                    ->orderby('starts_at', 'desc');


                $past = DB::table('activities')
                    ->where('ends_at','<', Carbon::now())
                    ->orderby('starts_at', 'desc');

                $query->where('starts_at','<' ,Carbon::now())
                    ->where('ends_at','>', Carbon::now())
                    ->orderby('starts_at', 'desc')
                    ->union($upcoming)
                    ->union($past);


            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.activity.index', ['data' => $data]);
    }

    public function participants(Activity $activity, IndexParticipant $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Participant::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'enrolled_at', 'user_id', 'attendance_id'],

            // set columns to searchIn
            ['id'],

            function ($query) use ($activity) {
                $query->where('activity_id', $activity->id)
                      ->with([
                            'attendance:id,arrived_at,left_at',
                            'user:id,name',
                            'activity:id,name'
                        ]);
            }
        );

        if ($request->has('bulk')) {
            return [
                'bulkItems' => $data->pluck('id')
            ];
        }

        return ['data' => $data];
    }

    public function checkin(Activity $activity)
    {
        return view('admin.activity.checkin', [
            'activity' => $activity
        ]);
    }

    public function checkinOtp(Activity $activity)
    {
        $otp = resolve(\OTPHP\TOTP::class);

        return [
            'otp' => $otp->now()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.activity.create');

        return view('admin.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreActivity $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreActivity $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Activity
        $activity = Activity::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/activities'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/activities');
    }

    /**
     * Display the specified resource.
     *
     * @param Activity $activity
     * @throws AuthorizationException
     * @return void
     */
    public function show(Activity $activity)
    {
        $this->authorize('admin.activity.show', $activity);

        // TODO your code goes here
        return view('admin.activity.show', [
            'activity' => $activity
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Activity $activity
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Activity $activity)
    {
        $this->authorize('admin.activity.edit', $activity);


        return view('admin.activity.edit', [
            'activity' => $activity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateActivity $request
     * @param Activity $activity
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateActivity $request, Activity $activity)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Activity
        $activity->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/activities'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/activities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyActivity $request
     * @param Activity $activity
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyActivity $request, Activity $activity)
    {
        $activity->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyActivity $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyActivity $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Activity::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
