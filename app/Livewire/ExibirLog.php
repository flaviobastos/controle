<?php

namespace App\Livewire;

use App\Models\Log;
use Livewire\Component;

class ExibirLog extends Component
{
    public $logs;

    public function render()
    {
        // Obtém todos os logs em ordem decrescente (os mais recentes primeiro)
        $this->logs = Log::orderBy('created_at', 'desc')->get();
        
        return view('livewire.exibir-log');
    }
}
