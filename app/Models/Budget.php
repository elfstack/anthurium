<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'type',
        'item',
        'budget',
        'actual'
    ];
}
