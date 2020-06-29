<?php


namespace App\Models;

use App\Exceptions\AlreadyEnrolledException;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait CanParticipate
{
    /**
     * Participate activity
     *
     * @param Activity $activity
     * @throws AlreadyEnrolledException
     */
    public function participate(Activity $activity): void {
        $activity->addParticipant($this);
    }

    public function cancel(Activity $activity): void {

    }

    public function participatedActivities(): MorphToMany
    {
        return $this->morphToMany(
            Activity::class,
            'participant',
            'participations')
                ->using(Participation::class)
                ->as('details');
    }

    /**
     * Check if user is a participant
     *
     * @param Activity $activity
     * @return bool
     */
    public function isParticipant(Activity $activity): bool
    {
        return $activity->getParticipants($this)->exists();
    }

    /**
     * Check if two participants are the same
     *
     * @param Participant $participant
     * @return bool
     */
    public function equals(Participant $participant): bool
    {
        return $this->id == $participant->id && $this->getMorphClass() == $participant->getMorphClass();
    }
}
