<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'auth.login')->name('login');
Route::get('/dashboard', function() {
    return '<h1>Welcome to Admin Dashboard!</h1>';
})->name('dashboard')->middleware("auth");
