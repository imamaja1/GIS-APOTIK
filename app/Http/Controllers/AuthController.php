<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\ServisAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private ServisAuth $servisAuth) {}

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $role = $this->servisAuth->login($data['email'], $data['password']);

        if (! $role) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = $this->servisAuth->register($data['nama_user'], $data['email'], $data['password']);
        $this->servisAuth->loginUser($user);

        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function logout(): RedirectResponse
    {
        $this->servisAuth->logout();

        return redirect()->route('login');
    }
}
