<?php

namespace App\Models;

use App\ActivityUserGroup;
use App\Exceptions\AlreadyEnrolledException;
use App\Exceptions\InactiveActivityException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function userGroups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class, 'activity_user_groups');
    }

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
     * @throws InactiveActivityException
     */
    public function addParticipant(Participant $participant)
    {
        if ($this->getParticipants($participant)->exists()) {
            throw new AlreadyEnrolledException('user already enrolled');
        }

        if ($this->getStatus() != 'upcoming') {
            throw new InactiveActivityException();
        }

        $this->checkUserGroup($participant);

        // TODO: check if user can participate
        $this->getParticipants($participant)->save($participant);
    }

    /**
     * Check if user is able to join
     *
     * @param Participant $participant
     * @throws \Exception
     */
    private function checkUserGroup(Participant $participant)
    {
        $userGroup = $participant->userGroup;
        try {
            $this->userGroups()->findOrFail($userGroup->id);
        } catch (\Exception $exception) {
            throw new \Exception('the user is not permitted to join');
        }
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
    public function getParticipants(Participant $participant): BelongsToMany
    {
        $participants = $this->userParticipants();
        return $participants->where('user_id', $participant->id);
    }

    /**
     * @return BelongsToMany
     */
    private function userParticipants(): BelongsToMany
    {
        return $this->belongsToMany(User::class,
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
            $participation = $participations->where('user_id', $participant->id);

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
