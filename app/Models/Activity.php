<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
        'content',
        'quota',
    
    ];
    
    
    protected $dates = [
        'starts_at',
        'ends_at',
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/activities/'.$this->getKey());
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function usedQuotaPercentage()
    {
        return $this->participants()->count() / $this->quota * 100;
    }

    public function attendedParticipantsPercentage()
    {
        return $this->participants()->whereNotNull('attendance_id')->count() / $this->participants()->count() * 100;
    }
}
