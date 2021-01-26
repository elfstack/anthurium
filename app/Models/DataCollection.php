<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class DataCollection extends Model
{
    protected $table = 'data_collection';

    protected $fillable = [
        'form_id',
        'purpose', // FIXME: purpose
        'is_re_submittable'
    ];

    /**
     * @return BelongsTo
     */
    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }

    // TODO: the answer model class needs to be changed
    public function answers() : HasMany {
        return $this->hasMany(FormAnswer::class);
    }

    // TDO: the answer model class needs to be changed
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
