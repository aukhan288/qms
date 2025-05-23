<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelpers
{
    public static function hasRole($roles): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        $roles = is_array($roles) ? $roles : [$roles];
        return in_array($user->role->name, $roles);
    }

    public static function isAdmin(): bool
    {
        return self::hasRole('admin');
    }
}
