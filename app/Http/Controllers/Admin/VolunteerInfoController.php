<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VolunteerInfo\BulkDestroyVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\DestroyVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\IndexVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\StoreVolunteerInfo;
use App\Http\Requests\Admin\VolunteerInfo\UpdateVolunteerInfo;
use App\Models\VolunteerInfo;
use App\User;
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
     * Update the specified resource in storage.
     *
     * @param UpdateVolunteerInfo $request
     * @param VolunteerInfo $volunteerInfo
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVolunteerInfo $request, User $user)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VolunteerInfo
        $user->volunteerInfo()->updateOrCreate($sanitized);

        if ($request->ajax()) {
            return [
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/volunteer-infos');
    }
}
