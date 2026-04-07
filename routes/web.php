<?php

use App\Http\Controllers\GoogleAuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/register')->name('home');
Route::redirect('/login', '/sender/login')->name('login');
Route::view('/register', 'home')->name('register');
Route::redirect('/receiver', '/runner');
Route::redirect('/receiver/login', '/runner/login');
Route::redirect('/receiver/register', '/runner/register');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user instanceof User) {
        abort(403, 'No authenticated user.');
    }

    if ($user->hasRole('admin')) {
        return redirect('/admin');
    }

    if ($user->hasRole('sender')) {
        return redirect('/sender');
    }

    if ($user->hasRole('runner')) {
        return redirect('/runner');
    }

    if ($user->hasRole('receiver')) {
        return redirect('/receiver');
    }

    abort(403, 'No panel role assigned.');
})->middleware('auth')->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->middleware('auth')->name('logout');
