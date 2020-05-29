<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
     *
     */
    function activities(): MorphToMany;
}