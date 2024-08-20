<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    #[Layout('components.layouts.login-layout')]
    public function render()
    {
        return view('livewire.login');
    }
}
