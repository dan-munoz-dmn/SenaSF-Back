<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'user' => $result['user'],
            'token' => $result['token'],
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return response()->json([
            'user' => $result['user'],
            'token' => $result['token'],
        ]);
    }

     public function me(): JsonResponse
    {
        $user = $this->authService->me();

        return response()->json(['user' => $user]);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Sesión cerrada correctamente.']);
    }


}