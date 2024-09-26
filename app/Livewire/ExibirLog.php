<?php

namespace App\Livewire;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExibirLog extends Component
{
    public $logs;

    public function mount()
    {
        if (!Auth::user()->is_admin) {
            // Se o usuário não for admin, redireciona para o dashboard
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        // Obtém todos os logs em ordem decrescente (os mais recentes primeiro)
        $this->logs = Log::orderBy('created_at', 'desc')->get();

        return view('livewire.exibir-log');
    }
}
