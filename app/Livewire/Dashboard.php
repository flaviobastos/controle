<?php

namespace App\Livewire;

use App\Models\Contrato;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{

    public $listaContratos;
    public $listaPagamentos;
    public $seletorContratos;
    public $valorTotal;
    public $buscar;
    public $id_contrato;

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function clear() // Limpar o campo de pesquisa
    {
        $this->reset();
    }

    public function editPayment($id_editarPagamento)  // Envia  $id_editarPagamento para editar-pagamento
    {
        $this->dispatch('editPaymentById', $id_editarPagamento);
    }

    public function listContracts()
    {
        // Inicia a consulta básica
        $query = Contrato::with(['pagamentos' => function ($query) {
            $query->orderBy('vencimento', 'asc')->orderBy('parcela', 'asc');
        }])
            ->orderBy('contrato', 'asc');

        // Aplica o filtro se um ID de contrato específico foi selecionado
        if (!empty($this->id_contrato)) {
            $query->where('id', $this->id_contrato);
        }

        // Executa a consulta e armazena os resultados
        $this->listaContratos = $query->get();

        // Somando diretamente no banco de dados
        $this->valorTotal = Pagamento::whereIn('contrato_id', $this->listaContratos->pluck('id'))->sum('valor');
    }

    public function selectContracts()
    {
        $this->seletorContratos = Contrato::orderBy('contrato', 'asc')->get(); // Retorna todos os contratos ordenados
    }

    public function listPayments()
    {
        $this->listaPagamentos = Pagamento::all(); // Retorna todos os pagamentos como uma coleção
    }

    #[On('updateRender')] // Atualiza o render após atualizações
    public function render()
    {
        $this->listContracts();
        $this->listPayments();
        $this->selectContracts();

        return view('livewire.dashboard');
    }
}
