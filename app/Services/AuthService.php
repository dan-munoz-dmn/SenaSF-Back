<?php

namespace App\Services;

interface AuthService {

    public function register(array $data);
    public function login(array $credentials);
    public function me();
    public function logout();

}