<?php

namespace App\Services\Impl;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;

class AuthServiceImpl implements AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = auth('api')->login($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

   public function login(array $credentials)
    {
        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return null;
        }

        return [
            'user' => auth('api')->user(),
            'token' => $token
        ];
    }

    public function me()
    {
        return auth('api')->user();
    }

    public function logout()
    {
        auth('api')->logout();
        return true;
    }
}