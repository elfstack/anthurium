<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'activity_id',
        'budget_category_id',
        'budget',
        'expense',
        'name',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/budgets/'.$this->getKey());
    }

    public function budgetCategory()
    {
        return $this->belongsTo(BudgetCategory::class);
    }
}
