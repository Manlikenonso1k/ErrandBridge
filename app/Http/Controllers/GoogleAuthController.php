<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (! config('services.google.client_id') || ! config('services.google.client_secret') || ! config('services.google.redirect')) {
            return redirect()->route('register')->with('error', 'Google login is not configured yet. Set GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, and GOOGLE_REDIRECT_URI in your .env file.');
        }

        // Clear previous auth/session to avoid cross-project cookie leakage.
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            return redirect()->route('register')->with('error', 'Google login failed. Please try again.');
        }

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName() ?: 'Google User',
                'password' => Hash::make(Str::password(24)),
            ]
        );

        if (! $user->hasAnyRole(['admin', 'sender', 'runner', 'receiver'])) {
            $user->assignRole('sender');
        }

        Auth::login($user, true);

        request()->session()->regenerate();

        if ($user->hasRole('admin')) {
            return redirect('/admin')->with('success', 'Logged in with Google successfully.');
        }

        if ($user->hasRole('sender')) {
            return redirect('/sender')->with('success', 'Logged in with Google successfully.');
        }

        if ($user->hasAnyRole(['runner', 'receiver'])) {
            return redirect('/runner')->with('success', 'Logged in with Google successfully.');
        }

        return redirect('/')->with('success', 'Logged in with Google successfully.');
    }
}
