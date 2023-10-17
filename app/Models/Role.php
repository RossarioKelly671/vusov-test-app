<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use HasFactory;
    const ROLE_USER = "user";
    const ROLE_ADMIN = "admin";

    private int $id;
    private string $name;

    public static function getUserRole() {
        return Role::where("name", self::ROLE_USER)->firstOrFail();
    }

    public static function getAdminRole() {
        return Role::where("name", self::ROLE_ADMIN)->firstOrFail();
    }
}
