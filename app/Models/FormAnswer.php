<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FormAnswer extends Model
{
    protected $table = 'form_answers';

    public function answerer(): MorphTo {
        return $this->morphTo();
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }
}
