<?php

namespace App\Traits;

use App\Models\Role;

trait RoleAccessTrait
{

    public function hasRole($role): bool {
        return $this->role->name === $role;
    }

    public function isAdmin(): bool
    {
        return $this->role->name === Role::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role->name === Role::ROLE_USER;
    }

}
