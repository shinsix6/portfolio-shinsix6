<?php

use Livewire\Component;

new class extends Component
{
    public $email = '';
    public $password = '';

    public function login() 
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            session()->flash('message', "You are login successful.");
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'email and password are wrong.');
        }
    }
};
?>

<div class="d-flex align-items-center vh-100 justify-content-center">
    <div class="card p-4 shadow">
        <h3 class="text-center mb-4">Admin Login</h3>

         @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form wire:submit='login'>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" wire:model="email" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" wire:model="password" class="form-control">
                </div>

            <button type="submit" class="btn btn-primary w-100">
                Log In
            </button>
        </form>
    </div>
</div>