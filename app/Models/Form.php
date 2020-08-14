<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    protected $table = 'forms';

    protected $fillable = [
        'title',
        'description'
    ];

    public function questions() : hasMany {
        return $this->hasMany(FormQuestion::class);
    }

    public function answers() : hasMany {
        return $this->hasMany(FormAnswer::class);
    }
}
