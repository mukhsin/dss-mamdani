<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'auth.register')->name('register');
    Volt::route('login', 'auth.login')->name('login');
    Volt::route('forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'auth.reset-password')->name('password.reset');});

Route::middleware('auth')->group(function () {
    Route::get('logout', function (Logout $logout) {
        $logout();
        redirect()->route('welcome');
        // $this->redirect('/', navigate: true);
    });
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->name('verification.verify')->middleware(['signed', 'throttle:6,1']);
    Volt::route('verify-email', 'auth.verify-email')->name('verification.notice');
    Volt::route('confirm-password', 'auth.confirm-password')->name('password.confirm');});
