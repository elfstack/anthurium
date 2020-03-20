<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Attendance extends Model
{
    protected $fillable = [
        'arrived_at',
        'left_at',
        'activity_id',
        'user_id',
    
    ];
    
    
    protected $dates = [
        'arrived_at',
        'left_at',
    
    ];

    protected $table = "attendance";

    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/attendances/'.$this->getKey());
    }

    public function getUserAttendance(User $user)
    {
        return $this->where('user_id', $user->id);
    }
}
