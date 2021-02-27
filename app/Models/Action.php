<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    private $allowedTypes = [
        'member-registration'
    ];

    protected $fillable = [
        'type',
        'meta',
        'step',
        'user_id'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsCompleted()
    {
        $this->completed_at = Carbon::now();
    }

    public function restart()
    {
        $this->step = 0;
        $this->completed_at = null;
        $this->save();
    }

    public function loadMeta()
    {
        if ($this->meta['data_collection_response_id']) {
            $this->dataCollectionResponse =  DataCollectionResponse::with('response')->find($this->meta['data_collection_response_id']);
        }
    }

    public function hasChancesLeft()
    {
        return $this->chances_left > 0;
    }
}
