<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use App\Models\UserRecentLogin;

class LogSuccessfulLogin
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $ip = $this->request->ip();
        $userAgent = $this->request->header('User-Agent'); 
        $userId = $event->user->id;

        UserRecentLogin::create([
            'user_id' => $userId,
            'ip_address' => $ip,
            'user_agent' => $userAgent
        ]);

        $records = UserRecentLogin::where('user_id', $userId);

        if ($records->count() > 5) {
            $records->oldest('logged_at')->first()->delete();
        }
    }
}
