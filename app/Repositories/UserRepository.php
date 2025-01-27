<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function register(array $user): User
    {
        $data = new User($user);
        $data->save();

        return $data;
    }

    public function login(string $username): ?User
    {
        return User::query()->where('username', $username)->first();
    }

    public function logout(Authenticatable $user): void
    {
        $user->tokens()->delete();
    }
}
