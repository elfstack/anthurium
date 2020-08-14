<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOptions extends Model
{
    protected $table = 'form_options';

    protected $fillable = [
        'value'
    ];
}
