<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Participant
{
    /**
     * A participant may participate an activity
     *
     * @param Activity $activity
     */
    function participate(Activity $activity): void;

    /**
     * A participant may cancel his participation
     *
     * @param Activity $activity
     */
    function cancel(Activity $activity): void;

    /**
     * Get all activities of this participant
     * @deprecated use activitiesApplied instead
     */
    function participatedActivities(): BelongsToMany;

    // function activitiesApplied(): BelongsToMany;
    // function activitiesApproved(): BelongsToMany;

    function userGroup(): BelongsTo;

    function equals(Participant $participant): bool;
}
