<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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

        return redirect()->route('admin.dashboard');
    }

    public function logout(): RedirectResponse
    {
        $this->servisAuth->logout();

        return redirect()->route('login');
    }
}
