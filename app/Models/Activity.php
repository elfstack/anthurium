<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Activity extends Model
{
    public $fillable = [
        'name',
        'content',
        'is_published',
        'starts_at',
        'ends_at',
        'quota'
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
    }

    /**
     * Add a participant to this activity
     * @param Participant $participant
     * @throws \Exception
     */
    public function addParticipant(Participant $participant)
    {
        if ($this->getParticipant($participant)->exists()) {
            throw new \Exception('user already enrolled');
        }

        $this->getParticipant($participant)->save($participant, [
            'participant_type' => $participant->getMorphClass()
        ]);
    }

    /**
     * Get current participant
     *
     * @param Participant $participant
     * @return mixed
     */
    public function getParticipant(Participant $participant)
    {
        $morphRelation = call_user_func([$this, $participant->getMorphClass().'Participants']);
        return $morphRelation->where('participant_id', $participant->id);
    }

    /**
     * @return MorphToMany
     */
    private function userParticipants(): MorphToMany
    {
        return $this->morphedByMany(User::class,
            'participant',
            'participations')
            ->using(Participation::class)
            ->as('details')
            ->withTimestamps();
    }

    /**
     * @return MorphToMany
     */
    private function guestParticipants(): MorphToMany
    {
        return $this->morphedByMany(Guest::class,
            'participant',
            'participations')
            ->using(Participation::class)
            ->as('details')
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }
}
