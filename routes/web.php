<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::livewire('/', 'portfolio.homepage')
    ->name('home');
Route::livewire('/projects', 'portfolio.project-list')
    ->name('projects.index');

Route::livewire('/login', 'auth.login')
    ->name('login');
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

Route::livewire('/dashboard', 'admin.dashboard')
    ->name('dashboard')
    ->middleware("auth");
Route::livewire('/admin/genres', 'admin.manage-genre')
    ->middleware('auth');
