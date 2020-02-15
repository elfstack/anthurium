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

    const CREATED_AT = 'enrolled_at';

    const UPDATED_AT = null;

    protected $table = 'participants';
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/participants/'.$this->getKey());
    }
}
