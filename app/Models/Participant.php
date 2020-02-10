<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'enrolled_at',
        'activity_id',
        'user_id',
        'attendance_id',
    
    ];
    
    
    protected $dates = [
        'enrolled_at',
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/participants/'.$this->getKey());
    }
}
