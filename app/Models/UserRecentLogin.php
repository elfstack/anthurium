<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRecentLogin extends Model
{
    protected $table = 'user_recent_logins';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'logged_at',
    ];
    
    
    protected $dates = [
        'logged_at',
    
    ];

    const CREATED_AT = 'logged_at';
    const UPDATED_AT = null;
}
