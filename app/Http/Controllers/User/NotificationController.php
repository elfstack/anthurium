<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return NotificationCollection
     */
    public function index(Request $request)
    {
        $user = $request->user('api');

        $notifications = Listing::fromQuery($user->notifications())->get($request);

        // $notifications = NotificationCollection::collection($user->notifications);

        return new NotificationCollection($notifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param DatabaseNotification $notification
     * @return NotificationResource
     */
    public function show(DatabaseNotification $notification)
    {
        // TODO: check the notification is send to current user
        $notification->markAsRead();
        return new NotificationResource($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove a list of resources
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroySelected(Request $request)
    {
        $sanitized = $request->validate([
            'notification_ids' => 'array|required'
        ]);

        $user = $request->user('api');

        $user->notifications()->whereIn('id', $sanitized['notification_ids'])->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function markSelectedAsRead(Request $request)
    {
        $sanitized = $request->validate([
            'notification_ids' => 'array|required'
        ]);

        $user = $request->user('api');

        $notifications = $user->notifications()->whereIn('id', $sanitized['notification_ids'])->get();

        $notifications->markAsRead();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
