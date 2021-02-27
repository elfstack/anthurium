<?php


namespace App\Models;


interface UserInterface
{
    /**
     * Whether the user is admin
     *
     * @return mixed
     */
    public function isAdmin();
}
