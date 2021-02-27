<?php

namespace App\Http\Controllers\User;

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
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function findAction(Request $request)
    {
        $sanitized = $request->validate([
            'type' => 'required|string',
            'activity_id' => 'sometimes|exists:activities,id',
            'activity_phase' => 'sometimes'
        ]);

        $action = $request->user()->actions()->where('type', $sanitized)->first();
        $action->loadMeta();

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
            'restart' => 'boolean|required'
        ]);

        $status = 'failed';

        if ($action->is_terminated) {
            $status = 'terminated';
        }

        if (!$action->hasChancesLeft()) {
            $status = 'out of chance';
        }

        if ($sanitized['restart']) {
            $action->restart();
            $status = 'success';
        }

        return response()->json([
            'status' => $status
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
