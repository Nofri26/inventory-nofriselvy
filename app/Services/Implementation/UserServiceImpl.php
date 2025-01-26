<?php

namespace App\Services\Implementation;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    public function register(array $user): User
    {
        $data = new User($user);
        $data['password'] = Hash::make($user['password']);
        $data->save();

        return $data;
    }

    public function login(array $data): User
    {
        $user = User::query()->where('username', $data['username'])->first();
        Auth::login($user);
        $user['token'] = $user->createToken($data['username'])->plainTextToken;
        return $user;
    }
}
