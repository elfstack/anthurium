<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FormQuestionAnswers extends Pivot
{
    protected $table = 'form_question_answers';

    public function question(): BelongsTo {
        return $this->belongsTo(FormQuestion::class);
    }

    public function answer(): BelongsTo {
        return $this->belongsTo(FormAnswer::class);
    }
}
