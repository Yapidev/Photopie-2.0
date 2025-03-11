<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    #[Validate('required', as: 'Nama')]
    public string $name;

    #[Validate('required|email', as: 'Email')]
    public string $email;

    #[Validate('required|min:8', as: 'Kata Sandi')]
    public string $password;

    #[Validate('required|same:password', as: 'Konfirmasi Kata Sandi')]
    public string $confirmPassword;

    protected function rules()
    {
        return [
            'email' => Rule::unique('users', 'email')->ignore(auth()->id()),
            'name' => Rule::unique('users', 'nickname')
        ];
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->extends('auth.layouts.auth');
    }

    public function register()
    {
        // Validate the form
        $this->validate();

        // Create a new user
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'nickname' => $this->name,
        ]);

        // Session Flash
        session()->flash('success', 'Sudah berhasil mendaftar, silahkan login');

        // Redirect to the login page
        return $this->redirect('login', navigate: true);
    }
}
