<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

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

    public function answersAnsweredBy(User $user) {
        $answers = $this->answers()->whereHasMorph(
            'answerer',
            User::class,
            function (Builder $query) use ($user) {
                $query->where('id', $user->id);
            }
        )->first();

        $answers->load('answers');

        return $answers;
    }
}
