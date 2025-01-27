<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(protected UserRepository $repository) {}

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->repository->register($data);
    }

    public function login(array $data): User
    {
        $user = $this->repository->login($data['username']);
        auth()->login($user);
        $user['token'] = $user->createToken($data['username'])->plainTextToken;

        return $user;
    }

    public function logout(): Authenticatable
    {
        $user = auth()->user();
        $this->repository->logout($user);

        return $user;
    }
}
