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
    
    protected $appends = ['resource_url' ,'participants_count'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/activities/'.$this->getKey());
    }

    public function getParticipantsCountAttribute()
    {
        return $this->participants()->count();
    }

    /* *********************** RELATION ************************** */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Percantage of user participated in quota
     *
     * @return double
     */
    public function participantsPercentage()
    {
        return $this->participants()->count() / $this->quota;
    }

    /** Percantage of participants attended in quota
     *
     * @return double
     */
    public function attendedParticipantsPercentage()
    {
        if ($this->participants()->count() === 0) {
            return 0;
        }

        return $this->participants()->whereNotNull('attendance_id')->count() / $this->participants()->count() * 100;
    }
}
