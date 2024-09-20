<?php

namespace App\Livewire;

use App\Models\Fornecedor;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{

    public $listaFornecedores;
    public $listaPagamentos;
    public $seletorFornecedores;
    public $buscar = '';
    public $id_fornecedor;
    public $ano = null;
    public $mes;
    public $anosDisponiveis = [];
    public $mesesDisponiveis = [];
    public $filtroContrato = false; // Variável para controlar o estado do checkbox
    public $filtro = 'todos'; // Radio "Todos" selecionado por padrão

    public function logout()
    {
        // Realiza o logout do usuário atual
        Auth::logout();

        // Redireciona o usuário para a página de login
        return redirect()->route('login');
    }

    public function mount()
    {
        // Define a propriedade 'ano' com o valor do ano atual
        $this->ano = date('Y');

        // Chama a listagem de pagamentos inicialmente
        $this->listPayments();
    }

    public function clear() // Limpa os campos de pesquisa e estado do componente
    {
        // Limpa o campo de busca e executa a busca novamente
        $this->reset();
        $this->listPayments();
    }

    public function editPayment($id_editarPagamento)
    {
        // Envia o $id_editarPagamento para o evento 'editPaymentById', que será escutado em editar-pagamento.php
        $this->dispatch('editPaymentById', $id_editarPagamento);
    }

    public function selectPeriod()
    {
        // Obtém uma lista distinta de anos a partir da coluna 'vencimento' dos pagamentos
        // A função 'selectRaw' seleciona o ano e 'distinct' garante que não haja repetições
        // A lista é ordenada de forma decrescente (mais recente primeiro)
        // O 'pluck' extrai apenas a coluna 'ano' da consulta
        $this->anosDisponiveis = Pagamento::selectRaw('YEAR(vencimento) as ano')
            ->distinct()
            ->orderBy('ano', 'desc')
            ->pluck('ano');

        // Obtém uma lista distinta de meses a partir da coluna 'vencimento' dos pagamentos
        // A função 'selectRaw' seleciona o mês e 'distinct' garante que não haja repetições
        // A lista é ordenada de forma crescente (janeiro primeiro)
        // O 'pluck' extrai apenas a coluna 'mes' da consulta
        $this->mesesDisponiveis = Pagamento::selectRaw('MONTH(vencimento) as mes')
            ->distinct()
            ->orderBy('mes', 'asc')
            ->pluck('mes');
    }

    public function updatedBuscar()
    {
        // Inicia o valor convertido como o próprio valor buscado
        $valorConvertido = $this->buscar;

        // Verifica se o valor contém um formato numérico brasileiro (ex: 5.000,00)
        if (preg_match('/^[0-9]{1,3}(\.[0-9]{3})*,[0-9]{2}$/', $this->buscar)) {
            // Remove os pontos de milhar e substitui a vírgula decimal por ponto
            $valorConvertido = str_replace('.', '', $this->buscar);  // Remove pontos de milhar
            $valorConvertido = str_replace(',', '.', $valorConvertido);  // Substitui a vírgula por ponto
        }

        // Inicia a consulta diretamente no modelo de Pagamento
        $query = Pagamento::with('fornecedor')
            ->orderBy('vencimento', 'asc')
            ->orderBy('parcela', 'asc');

        // Aplica os filtros de busca nas colunas
        $query->where(function ($q) use ($valorConvertido) {
            $q->where('nota_fiscal', 'like', '%' . $this->buscar . '%')  // Filtra pela coluna nota_fiscal
                ->orWhere('contrato', 'like', '%' . $this->buscar . '%') // Filtra pela coluna contrato
                ->orWhere('cheque', 'like', '%' . $this->buscar . '%') // Filtra pela coluna cheque
                ->orWhere('parcela', 'like', '%' . $this->buscar . '%') // Filtra pela coluna parcela
                ->orWhere('responsavel', 'like', '%' . $this->buscar . '%') // Filtra pela coluna responsável
                ->orWhere('valor', 'like', '%' . $valorConvertido . '%'); // Filtra pela coluna valor usando o valor convertido
        });

        // Executa a consulta e armazena os resultados
        $this->listaPagamentos = $query->get();
    }

    public function listPayments()
    {
        // Inicia a consulta diretamente no modelo de Pagamento
        $query = Pagamento::with('fornecedor') // Inclui o relacionamento do fornecedor
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
                // Filtra os registros onde 'data_pagamento' não é nulo (pagamentos realizados)
                $query->whereNotNull('data_pagamento');
                break;
            case 'abertos':
                // Filtra os registros onde 'data_pagamento' é nulo (pagamentos em aberto)
                $query->whereNull('data_pagamento');
                break;
            case 'vencimentos':
                // Filtra os registros onde 'vencimento' é menor ou igual à data atual (pagamentos vencidos)
                // e onde 'data_pagamento' é nulo (não pagos)
                $query->where('vencimento', '<=', now())
                    ->whereNull('data_pagamento');
                break;
            case 'todos':
            default:
                // Não aplica nenhum filtro adicional, exibe todos os registros
                break;
        }

        // Verifica se o checkbox de "Apenas Pgtos C/ Contrato" está marcado
        if ($this->filtroContrato) {
            $query->whereNotNull('contrato');
        }

        // Aplica o filtro se um ID de fornecedor específico foi selecionado
        if (!empty($this->id_fornecedor)) {
            $query->where('fornecedor_id', $this->id_fornecedor);
        }

        // Executa a consulta e armazena os resultados
        $this->listaPagamentos = $query->get();
    }

    public function selectSuppliers()
    {
        // Obtém todos os fornecedores da tabela 'fornecedor' e ordena por nome de forma ascendente
        $this->seletorFornecedores = Fornecedor::orderBy('fornecedor', 'asc')->get();
    }

    public function applyFilter()
    {
        // Aplica o filtro chamando o método 'listPayments', que provavelmente filtra os pagamentos
        $this->listPayments();
    }

    #[On('updateRender')] // Define que a função 'render' será atualizada após o evento 'updateRender'
    public function render()
    {
        // Verifica se o campo de busca está vazio
        if (!empty($this->buscar)) {
            // Se houver busca, utiliza o método de busca (updatedBuscar)
            $this->updatedBuscar();
        } else {
            // Se não houver busca, carrega a lista geral de pagamentos
            $this->listPayments();
        }

        // Atualiza a lista de fornecedores
        $this->selectSuppliers();

        // Atualiza a lista de anos e meses disponíveis
        $this->selectPeriod();

        // Renderiza a visão 'dashboard'
        return view('livewire.dashboard');
    }
}
