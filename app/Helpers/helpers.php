<?php

use App\Helpers\RoleHelpers;

if (!function_exists('hasRole')) {
    function hasRole($roles)
    {
        return RoleHelpers::hasRole($roles);
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return RoleHelpers::isAdmin();
    }
}

if (!function_exists('generatePassword')) {
    function generatePassword($length = 8): string
    {
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specials = '!@#$%^&*()-_=+';

        $password = [
            $letters[random_int(0, strlen($letters) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specials[random_int(0, strlen($specials) - 1)],
        ];

        $all = $letters . $numbers . $specials;
        for ($i = count($password); $i < $length; $i++) {
            $password[] = $all[random_int(0, strlen($all) - 1)];
        }

        shuffle($password);

        return implode('', $password);
    }
}