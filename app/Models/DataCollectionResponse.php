<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataCollectionResponse extends Model
{
    protected $table = 'data_collection_responses';

    public $fillable = [
        'form_question_id',
        'answer',
        'user_id'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(FormQuestion::class, 'form_question_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(FormAnswer::class);
    }
}
