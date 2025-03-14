<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|email', as: 'Email')]
    public string $email;

    #[Validate('required|min:8', as: 'Kata Sandi')]
    public string $password;

    public bool $remember = false;

    public function rules()
    {
        return [
            'email' => Rule::unique('users', 'email')->ignore(auth()->id()),
        ];
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->extends('auth.layouts.auth');
    }

    public function login()
    {
        // Validate data
        $this->validate();

        // Get the credentials
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $this->remember)) {
            // Session Flash
            session()->flash('success', 'Login berhasil');

            // User authenticated, redirect to the dashboard
            return $this->redirectIntended('user/dashboard', navigate: true);
        }

        // User failed to authenticate, display error message
        $this->dispatch('notify', icon: 'error', title: 'Gagal', message: 'Email atau password salah');
    }
}
