<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FormAnswer extends Model
{
    protected $table = 'form_question_answers';

    protected $fillable = [
        'answer',
        'form_question_id'
    ];

    public $timestamps = false;

    public function answerer(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(FormQuestion::class);
    }

    // TODO: this needs to be verified
    public function response(): BelongsTo
    {
        return $this->belongsTo(DataCollectionResponse::class);
    }
}
