<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    public function register(array $user): User;

    public function login(array $data): User;
}
