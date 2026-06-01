<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'auth.login')->name('login');
Route::livewire('/dashboard', 'admin.dashboard')
    ->name('dashboard')
    ->middleware("auth");
