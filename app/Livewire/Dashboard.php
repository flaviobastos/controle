<?php

namespace App\Livewire;

use App\Models\Contrato;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public $listaContratos;
    public $buscar;

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function listContracts()
    {
        $this->listaContratos = Contrato::with(['pagamentos' => function ($query) {
            $query->orderBy('vencimento', 'asc')->orderBy('parcela', 'asc');
        }])
            ->orderBy('contrato', 'asc')
            ->get();
    }

    public function render()
    {

        $this->listContracts();

        return view('livewire.dashboard');
    }
}
