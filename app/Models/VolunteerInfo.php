<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerInfo extends Model
{
    protected $fillable = [
        'user_id',
        'id_number',
        'alias',
        'gender',
        'birthday',
        'education',
        'organisation',
        'mobile_number',
        'address',
        'interests',
        'emergency_contact',
        'volunteer_experences',
        'references',
    ];

    protected $table = "volunteer_info";

    protected $primaryKey = "user_id";
    
    protected $dates = [
        'birthday',
    
    ];

    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/user/'.$this->getKey().'/volunteer-info');
    }
}
