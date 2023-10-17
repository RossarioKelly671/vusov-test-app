<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserManagementPolicy
{

    public function create(User $currentUser): Response
    {
        return $currentUser->hasRole(Role::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny("You cant create this user.");
    }

    public function update(User $currentUser, User $targetUser): Response
    {
        return $currentUser->hasRole(Role::ROLE_ADMIN) || $currentUser->id == $targetUser->id
            ? Response::allow()
            : Response::deny("You cant update this user.");
    }


    public function show(User $currentUser, User $targetUser): Response
    {
        return $currentUser->hasRole(Role::ROLE_ADMIN) || $currentUser->id == $targetUser->id
            ? Response::allow()
            : Response::deny("You cant get this user.");
    }

    public function delete(User $currentUser, User $targetUser): Response
    {
        return $currentUser->hasRole(Role::ROLE_ADMIN) || $currentUser->id == $targetUser->id
            ? Response::allow()
            : Response::deny("You cant delete this user.");
    }

}
