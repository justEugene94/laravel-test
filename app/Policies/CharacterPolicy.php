<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Character  $character
     * @return mixed
     */
    public function view(User $user, Character $character)
    {
        return true;
    }
}
