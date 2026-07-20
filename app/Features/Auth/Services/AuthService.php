<?php

namespace App\Features\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $credentials): ?User
    {
        if (Auth::attempt($credentials, $credentials['remember'] ?? false)) {
            return Auth::user();
        }
        return null;
    }
}