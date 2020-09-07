<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormQuestionAnswers extends Model
{
    protected $table = 'form_question_answers';

    public $timestamps = false;

    public $fillable = [
        'form_question_id',
        'answer'
    ];

    public function question(): belongsTo
    {
        return $this->belongsTo(FormQuestion::class, 'form_question_id');
    }
}
