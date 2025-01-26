<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->register($data);

        return response()->json([
            'message' => 'User register successfully.',
            'data' => new UserResource($user),
        ])->setStatusCode(201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->login($data);

        return response()->json([
            'message' => 'User login successfully.',
            'data' => new UserResource($user),
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'User logout successfully.',
            'data' => new UserResource($user),
        ]);
    }
}
