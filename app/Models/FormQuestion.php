<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormQuestion extends Model
{
    protected $table = 'form_questions';

    protected $fillable = [
        'sequence',
        'type',
        'question',
        'is_required',
        'max_character'
    ];

    public function options(): hasMany {
        return $this->hasMany(FormOptions::class);
    }
}
