<?php

namespace App\Livewire;

use App\Models\Contrato;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public $listaContratos;
    public $listaPagamentos;

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function listContracts() // Carrega a lista de contratos
    {
        $this->listaContratos = Contrato::orderBy('contrato', 'asc')->get();
    }

    public function listPayments() // Carrega a lista de pagamentos
    {
        $this->listaPagamentos = Pagamento::orderBy('vencimento', 'asc')->get();
    }

    public function render()
    {
        if (!$this->listaContratos) {
            $this->listContracts();
        }
        if (!$this->listaPagamentos) {
            $this->listPayments();
        }
        return view('livewire.dashboard');
    }
}
