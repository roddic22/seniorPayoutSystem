<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        Log::info('User logged in', [
            'user_id'   => Auth::id(),
            'name'      => Auth::user()->name,
            'role'      => Auth::user()->role,
            'ip'        => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return redirect()->intended(route('dashboard'));
    }

    Log::warning('Failed login attempt', [
        'email'     => $request->email,
        'ip'        => $request->ip(),
        'timestamp' => now()->toDateTimeString(),
    ]);

    return back()
        ->withErrors(['email' => 'The provided credentials do not match our records.'])
        ->onlyInput('email');
}

public function logout(Request $request): RedirectResponse
{
    Log::info('User logged out', [
        'user_id'   => Auth::id(),
        'name'      => Auth::user()->name,
        'timestamp' => now()->toDateTimeString(),
    ]);

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}