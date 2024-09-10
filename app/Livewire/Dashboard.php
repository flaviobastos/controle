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
    public $buscar;
    public $id_contrato;
    public $ano = null;
    public $mes;
    public $anosDisponiveis = [];
    public $mesesDisponiveis = [];
    public $filtro = 'todos'; // Radio "Todos" selecionado por padrão

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function mount()
    {
        $this->ano = date('Y'); // Define o ano atual
    }

    public function clear() // Limpar o campo de pesquisa
    {
        $this->reset();
    }

    public function editPayment($id_editarPagamento)  // Envia $id_editarPagamento para editar-pagamento
    {
        $this->dispatch('editPaymentById', $id_editarPagamento);
    }

    public function selectPeriod()
    {
        $this->anosDisponiveis = Pagamento::selectRaw('YEAR(vencimento) as ano')
            ->distinct()
            ->orderBy('ano', 'desc')
            ->pluck('ano');

        $this->mesesDisponiveis = Pagamento::selectRaw('MONTH(vencimento) as mes')
            ->distinct()
            ->orderBy('mes', 'asc')
            ->pluck('mes');
    }

    public function listContracts()
    {
        // Inicia a consulta diretamente no modelo de Pagamento
        $query = Pagamento::with('contrato') // Inclui o relacionamento do contrato
            ->orderBy('vencimento', 'asc')   // Ordena por vencimento
            ->orderBy('parcela', 'asc');     // Ordena por parcela

        // Aplica filtro por ano, se fornecido
        if (!empty($this->ano)) {
            $query->whereYear('vencimento', $this->ano);
        }

        // Aplica filtro por mês, se fornecido
        if (!empty($this->mes)) {
            $query->whereMonth('vencimento', $this->mes);
        }

        // Aplica o filtro baseado no valor do radio selecionado
        switch ($this->filtro) {
            case 'pagos':
                // Mostrar somente pagamentos que têm data_pagamento
                $query->whereNotNull('data_pagamento');
                break;
            case 'abertos':
                // Mostrar somente pagamentos em aberto (data_pagamento é null)
                $query->whereNull('data_pagamento');
                break;
            case 'vencimentos':
                // Mostrar pagamentos em vencimento (vencimento <= data atual e data_pagamento é null)
                $query->where('vencimento', '<=', now())
                    ->whereNull('data_pagamento');
                break;
            case 'todos':
            default:
                // Não aplica nenhum filtro adicional, mostra todos os pagamentos
                break;
        }

        // Aplica o filtro se um ID de contrato específico foi selecionado
        if (!empty($this->id_contrato)) {
            $query->where('contrato_id', $this->id_contrato);
        }

        // Executa a consulta e armazena os resultados
        $this->listaPagamentos = $query->get();
    }

    public function selectContracts()
    {
        $this->seletorContratos = Contrato::orderBy('contrato', 'asc')->get(); // Retorna todos os contratos ordenados
    }

    public function applyFilter()
    {
        $this->listContracts();
    }

    #[On('updateRender')] // Atualiza o render após atualizações
    public function render()
    {
        $this->listContracts();
        $this->selectContracts();
        $this->selectPeriod();

        return view('livewire.dashboard');
    }
}
