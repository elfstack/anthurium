<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $fillable = [
        'name',
        'content',
        'is_published'
    ];

    public $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    /**
     * Get the status of activity
     *
     * @return string
     */
    public function getStatus()
    {
        if (!$this->is_published) {
            return 'draft';
        }

        $now = Carbon::now();

        if ($now->gt($this->ends_at)) {
            return 'past';
        } else if ($now->lt($this->starts_at)) {
            return 'upcoming';
        } else {
            return 'ongoing';
        }

        return 'unknown';
    }
}
