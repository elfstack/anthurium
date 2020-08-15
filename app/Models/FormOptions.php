<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOptions extends Model
{
    protected $table = 'form_options';

    public $timestamps = false;

    protected $fillable = [
        'value'
    ];

    protected $hidden = [
        'form_question_id'
    ];
}
