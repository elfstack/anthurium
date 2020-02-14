<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Participant extends Pivot
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

    protected $table = 'participants';

    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/participants/'.$this->getKey());
    }
}
