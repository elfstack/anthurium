<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VolunteerInfo\BulkDestroyVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\DestroyVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\IndexVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\StoreVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\UpdateVolunteerInfo;
use App\Models\VolunteerInfo;
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

class VolunteerInfoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVolunteerInfo $request
     * @return array|Factory|View
     */
    public function index(IndexVolunteerInfo $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VolunteerInfo::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['user_id', 'id_number', 'alias', 'gender', 'birthday', 'education', 'organisation', 'mobile_number', 'address', 'interests', 'emergency_contact', 'volunteer_experences', 'references'],

            // set columns to searchIn
            ['id_number', 'alias', 'gender', 'education', 'organisation', 'mobile_number', 'address', 'interests', 'emergency_contact', 'volunteer_experences', 'references']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.volunteer-info.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.volunteer-info.create');

        return view('admin.volunteer-info.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVolunteerInfo $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVolunteerInfo $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the VolunteerInfo
        $volunteerInfo = VolunteerInfo::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/volunteer-infos'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/volunteer-infos');
    }

    /**
     * Display the specified resource.
     *
     * @param VolunteerInfo $volunteerInfo
     * @throws AuthorizationException
     * @return void
     */
    public function show(VolunteerInfo $volunteerInfo)
    {
        $this->authorize('admin.volunteer-info.show', $volunteerInfo);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VolunteerInfo $volunteerInfo
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VolunteerInfo $volunteerInfo)
    {
        $this->authorize('admin.volunteer-info.edit', $volunteerInfo);


        return view('admin.volunteer-info.edit', [
            'volunteerInfo' => $volunteerInfo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVolunteerInfo $request
     * @param VolunteerInfo $volunteerInfo
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVolunteerInfo $request, VolunteerInfo $volunteerInfo)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VolunteerInfo
        $volunteerInfo->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/volunteer-infos'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/volunteer-infos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVolunteerInfo $request
     * @param VolunteerInfo $volunteerInfo
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVolunteerInfo $request, VolunteerInfo $volunteerInfo)
    {
        $volunteerInfo->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVolunteerInfo $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVolunteerInfo $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VolunteerInfo::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
