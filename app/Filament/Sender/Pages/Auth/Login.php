<?php

namespace App\Filament\Sender\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        if (! Filament::auth()->user()?->hasRole('sender')) {
            Filament::auth()->logout();

            throw ValidationException::withMessages([
                'data.email' => 'Your account is not authorized for the sender panel.',
            ]);
        }

        return $response;
    }
}
