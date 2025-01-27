<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserRepositoryInterface
{
    public function register(array $user): User;

    public function login(string $username): ?User;

    public function logout(Authenticatable $user): void;
}
