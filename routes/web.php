<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/sign-in', 'signIn')->name('signIn');

    Route::get('/register', 'register')->name('register');
    Route::post('/sign-up', 'signUp')->name('signUp');


    Route::get('/forgot-password', 'forgot')
        ->middleware('guest')
        ->name('forgot');

    Route::post('/forgot-password', 'forgotPassword')
        ->middleware('guest')
        ->name('forgot-password');

    Route::get('/reset-password/{token}', 'reset')
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', 'resetPassword')
        ->middleware('guest')
        ->name('password-reset');

    Route::delete('/logout', 'logout')->name('logout');


    Route::get('/auth/socialite/github', 'redirect')
        ->name('socialite.redirect');

    Route::get('/auth/socialite/github/callback', 'callback')
        ->name('socialite.callback');

});



