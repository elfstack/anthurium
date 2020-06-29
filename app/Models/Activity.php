<?php

namespace App\Models;

use App\Exceptions\AlreadyEnrolledException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'content',
        'is_published',
        'starts_at',
        'ends_at',
        'quota'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    // TODO: this has to be improved
    protected $appends = [
        'approved_participants'
    ];

    protected static function booted()
    {
        static::updating(function ($activity) {
            // TODO: set all participant status
        });
    }

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
     * @throws AlreadyEnrolledException
     */
    public function addParticipant(Participant $participant)
    {
        if ($this->getParticipants($participant)->exists()) {
            throw new AlreadyEnrolledException('user already enrolled');
        }

        // TODO: check if user can participate

        $this->getParticipants($participant)->save($participant, [
            'participant_type' => $participant->getMorphClass()
        ]);
    }

    public function getApprovedParticipantsAttribute()
    {
        return $this->participations()
                    ->whereNotNull('approved_at')
                    ->count();
    }

    /**
     * Get participant with the same type as param
     *
     * @param Participant $participant
     * @return MorphToMany
     */
    public function getParticipants(Participant $participant): MorphToMany
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
     * Get participations or participation
     *
     * @param Participant|null $participant filter the record
     * @return HasMany | Participation
     */
    public function participations(Participant $participant=null)
    {
        $participations = $this->hasMany(Participation::class);

        if ($participant != null) {
            $participation = $participations->where('participant_type', $participant->getMorphClass())
                           ->where('participant_id', $participant->id);

            return Participation::fromRawAttributes(
                $this,
                $participation->first()->toArray(),
                'participations',
                $participation->exists()
            );
        }

        return $participations;
    }
}
