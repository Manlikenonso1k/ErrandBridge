<?php

namespace App\Filament\Runner\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        if (! Filament::auth()->user()?->hasRole('runner')) {
            Filament::auth()->logout();

            throw ValidationException::withMessages([
                'data.email' => 'Your account is not authorized for the runner panel.',
            ]);
        }

        return $response;
    }
}
