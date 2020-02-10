<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attendance\BulkDestroyAttendance;
use App\Http\Requests\Admin\Attendance\DestroyAttendance;
use App\Http\Requests\Admin\Attendance\IndexAttendance;
use App\Http\Requests\Admin\Attendance\StoreAttendance;
use App\Http\Requests\Admin\Attendance\UpdateAttendance;
use App\Models\Attendance;
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

class AttendanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAttendance $request
     * @return array|Factory|View
     */
    public function index(IndexAttendance $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Attendance::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'arrived_at', 'left_at', 'activity_id', 'user_id'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.attendance.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.attendance.create');

        return view('admin.attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAttendance $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAttendance $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Attendance
        $attendance = Attendance::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/attendances'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/attendances');
    }

    /**
     * Display the specified resource.
     *
     * @param Attendance $attendance
     * @throws AuthorizationException
     * @return void
     */
    public function show(Attendance $attendance)
    {
        $this->authorize('admin.attendance.show', $attendance);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Attendance $attendance
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Attendance $attendance)
    {
        $this->authorize('admin.attendance.edit', $attendance);


        return view('admin.attendance.edit', [
            'attendance' => $attendance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttendance $request
     * @param Attendance $attendance
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAttendance $request, Attendance $attendance)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Attendance
        $attendance->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/attendances'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/attendances');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAttendance $request
     * @param Attendance $attendance
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAttendance $request, Attendance $attendance)
    {
        $attendance->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAttendance $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAttendance $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Attendance::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
