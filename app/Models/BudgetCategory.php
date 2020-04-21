<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    protected $fillable = [
        'name',
    
    ];
    
    
    protected $dates = [
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/budget-categories/'.$this->getKey());
    }
}
