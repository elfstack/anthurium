<?php

namespace App\Models;

use App\Utils\ConfigUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DataCollection extends Model
{
    protected $table = 'data_collection';

    protected $fillable = [
        'form_id',
        'purpose', // FIXME: purpose
        'activity_id',
        'meta',
        'available_to',
        'is_re_submittable'
    ];

    protected $casts = [
        'meta' => 'json',
        'available_to' => 'datetime'
    ];

    const REGISTRATION = 'registration';

    /**
     * @return DataCollection
     */
    public static function memberApplicationForm()
    {
        return self::where('purpose', 'member-application')->firstOrFail();
    }

    /**
     * @return BelongsTo
     */
    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }

    public function activity(): BelongsTo {
        return $this->belongsTo(Activity::class);
    }

    // TODO: the answer model class needs to be changed
    public function response() : HasMany {
        return $this->hasMany(DataCollectionResponse::class);
    }

    public function isFilledByUser(User $user) {
        return $this->response()->where('user_id', $user->id)->exists();
    }

    /**
     * Get user's response of this data collection, together with question and answer
     *
     * TODO: argument of whether or not attach question to answer
     *
     * @param User $user
     * @param bool $withQuestion
     * @return HasMany
     */
    public function getResponseByUser(User $user, $withQuestion=true) {
        $response = $this->response()->where('user_id', $user->id)->firstOrFail();
        $response->load('response');

        return $response;
    }
}
