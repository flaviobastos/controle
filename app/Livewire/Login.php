<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $email;
    public $password;

    protected array $rules = [
        'email' => 'required|email|min:5|max:30',
        'password' => 'required|min:5|max:20',
    ];

    protected array $messages = [
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.min' => 'O campo de e-mail deve ter pelo menos 5 caracteres.',
        'email.max' => 'O campo de e-mail não deve ter mais de 30 caracteres.',
        'password.required' => 'O campo senha é obrigatório.',
        'password.min' => 'O campo de senha deve ter pelo menos 5 caracteres.',
        'password.max' => 'O campo de senha não deve ter mais de 20 caracteres.',
    ];

    public function login()
    {
        $validatedData = $this->validate();

        if (Auth::attempt($validatedData)) {
            session()->regenerate();
            return redirect()->route('dashboard');
        }

        $this->dispatch('loginFailed');
        //return redirect()->route('login');
    }

    #[Layout('components.layouts.login-layout')]
    public function render()
    {
        return view('livewire.login');
    }
}
