<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class DataCollectionResponse extends Model
{
    protected $table = 'data_collection_responses';

    public $fillable = [
        'answer',
        'user_id'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(FormAnswer::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(FormQuestion::class, 'form_question_answers');
    }

    public function response()
    {
        return $this->questions()->withPivot(['answer'])->as('response');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
