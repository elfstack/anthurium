<?php

namespace App\Policies;

use App\Models\DataCollectionResponse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataCollectionResponsePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  DataCollectionResponse  $dataCollectionResponse
     * @return mixed
     */
    public function view(User $user, DataCollectionResponse $dataCollectionResponse)
    {
        return $user->id === $dataCollectionResponse->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  DataCollectionResponse  $dataCollectionResponse
     * @return bool
     */
    public function update(User $user, DataCollectionResponse $dataCollectionResponse)
    {
        return $user->id === $dataCollectionResponse->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param DataCollectionResponse  $dataCollectionResponse
     * @return mixed
     */
    public function delete(User $user, DataCollectionResponse $dataCollectionResponse)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param DataCollectionResponse  $dataCollectionResponse
     * @return mixed
     */
    public function restore(User $user, DataCollectionResponse $dataCollectionResponse)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param DataCollectionResponse  $dataCollectionResponse
     * @return mixed
     */
    public function forceDelete(User $user, DataCollectionResponse $dataCollectionResponse)
    {
        //
    }
}
