<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\DataCollectionResponse;
use App\Notifications\MemberApplicationResult;
use App\Utils\Listing;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $actions = Listing::create(Action::class)
            ->attachFiltering(['type'])
            ->modifyQuery(function ($query) use ($request) {
                $query->with('user');
                if ($request->query('pending')) {
                    $query->whereNull('completed_at');
                }
            })
            ->get($request);

        return response()->json($actions);
    }

    /**
     * Display the specified resource.
     *
     * @param Action $action
     * @return JsonResponse
     */
    public function show(Action $action)
    {
        $action->load('user');

        $meta = $action->meta;

        // FIXME: this should be resolved in form, also the model needs to be renamed
        // FIXME: for membership application, the record was not inserted correctly

        if ($meta['data_collection_response_id']) {
            $data_collection_response = DataCollectionResponse::with('response')->find($meta['data_collection_response_id']);
            $action->data_collection_response = $data_collection_response;
        }

        return response()->json([
            'action' => $action
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Action $action
     * @return JsonResponse
     */
    public function update(Request $request, Action $action)
    {
        $sanitized = $request->validate([
            'result' => 'required'
        ]);

        if ($action->type == 'member-application') {
            if ($sanitized['result'] === 'rejected') {
                $action->user->notify(new MemberApplicationResult('rejected'));
                $action->chances_left = $action->chances_left - 1;
            } else if ($sanitized['result'] === 'approved') {
                $action->user->setUserGroup('member');
                $action->user->notify(new MemberApplicationResult('approved'));
                $action->user->save();

                $action->chances_left = 0;
                $action->is_terminated = true;
            }
        }

        $action->markAsCompleted();
        // TODO: this is a temporary measure
        $action->result = $sanitized['result'];
        $action->step = 2;
        $action->save();

        return response()->json([
            'status' => 'done'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
