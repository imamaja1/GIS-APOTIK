<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServisAuth
{
    public function login(string $email, string $password, bool $remember = false): ?string
    {
        if (Auth::guard('admin')->attempt([
            'email'    => $email,
            'password' => $password,
        ], $remember)) {
            return 'admin';
        }

        if (Auth::guard('web')->attempt([
            'email'    => $email,
            'password' => $password,
        ], $remember)) {
            return 'user';
        }

        return null;
    }

    public function register(string $namaUser, string $email, string $password): User
    {
        return User::create([
            'nama_user' => $namaUser,
            'email'     => $email,
            'password'  => $password,
        ]);
    }

    public function loginUser(User $user): void
    {
        Auth::guard('web')->login($user);
    }

    public function loginAdmin(Admin $admin): void
    {
        Auth::guard('admin')->login($admin);
    }

    public function logout(): void
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        session()->invalidate();
        session()->regenerateToken();
    }
}
