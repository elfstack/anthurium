<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait CanParticipate
{
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
        return $activity->getParticipant($this)->exists();
    }
}
