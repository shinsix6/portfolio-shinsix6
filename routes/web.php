<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'portfolio.homepage')
    ->name('home');
Route::livewire('/projects', 'portfolio.project-list')
    ->name('projects.index');

Route::livewire('/login', 'auth.login')
    ->name('login');
Route::livewire('/dashboard', 'admin.dashboard')
    ->name('dashboard')
    ->middleware("auth");
