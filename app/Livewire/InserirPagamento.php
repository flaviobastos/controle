<?php

namespace App\Livewire;

use App\Models\Fornecedor;
use App\Models\Pagamento;
use Livewire\Attributes\On;
use Livewire\Component;

class InserirPagamento extends Component
{
    public $listaFornecedores;
    public $fornecedor_id;
    public $tipoPagamento;
    public $responsavel; // Campo do formulário
    public $contrato; // Campo do formulário
    public $vencimento; // Campo do formulário
    public $parcela = 1; // Campo do formulário
    public $valor = []; // Campo do formulário
    public $nota_fiscal = []; // Campo do formulário

    protected $rules = [
        'responsavel' => 'required',  // Campo obrigatório para o responsável
        'vencimento' => 'required',  // Campo obrigatório para a data de vencimento
        'parcela' => 'required',  // Campo obrigatório para a quantidade de parcelas
        'nota_fiscal' => 'required',  // Campo obrigatório para a nota fiscal
        'valor' => 'required',  // Campo obrigatório para o valor
        'contrato' => 'nullable',  // O contrato é opcional
        // 'data_pagamento' => 'nullable|date',
        // 'data_manutencao' => 'nullable|date',
    ];

    public function updatedParcela($qtdParcelas) // Chamado ao atualizar a quantidade de parcelas
    {
        $qtdParcelas = max(1, intval($qtdParcelas));  // Garante que o valor seja pelo menos 1
        $this->parcela = $qtdParcelas;

        // Ajusta os arrays $valor e $nota_fiscal de acordo com o número de parcelas
        $this->valor = array_pad(array_slice($this->valor, 0, $this->parcela), $this->parcela, '');
        $this->nota_fiscal = array_pad(array_slice($this->nota_fiscal, 0, $this->parcela), $this->parcela, '');
    }

    public function mount() // Inicializa os valores ao montar o componente
    {
        // Garante que sempre haja pelo menos um campo de valor
        if (count($this->valor) < 1) {
            $this->valor[] = '';
        }

        // Garante que sempre haja pelo menos um campo de nota fiscal
        if (count($this->nota_fiscal) < 1) {
            $this->nota_fiscal[] = '';
        }
    }

    public function save() // Salva o pagamento no banco de dados
    {
        try {
            // Valida os dados conforme as regras
            $validated = $this->validate();

            // Converte os campos para uppercase usando mb_strtoupper() com encoding UTF-8
            $validated['responsavel'] = mb_strtoupper($validated['responsavel'], 'UTF-8');

            // Adiciona o fornecedor_id ao array validado
            $validated['fornecedor_id'] = $this->fornecedor_id;

            // Remove separadores de milhar e converte o valor para o formato correto
            $this->valor = str_replace('.', '', $this->valor);  // Remove os pontos
            $this->valor = str_replace(',', '.', $this->valor);  // Substitui a vírgula decimal por ponto
            $validated['valor'] = $this->valor;

            // Converte a data de vencimento para um objeto DateTime
            $vencimento = new \DateTime($this->vencimento);

            // Verifica se o tipo de pagamento deve incluir o contrato ou não
            $contrato = $this->tipoPagamento ? $this->contrato : null;

            // Itera sobre as parcelas e salva cada uma como uma linha separada no banco
            foreach ($this->nota_fiscal as $index => $notaFiscal) {
                // Prepara os dados para inserir no banco de dados
                $dados = [
                    'responsavel' => $validated['responsavel'],
                    'vencimento' => $vencimento,  // Define o vencimento desta parcela
                    'parcela' => $index + 1,  // Índice baseado em 1 para a parcela
                    'nota_fiscal' => $notaFiscal,
                    'valor' => $this->valor[$index],
                    'fornecedor_id' => $validated['fornecedor_id'],  // Inclui o fornecedor_id
                    'contrato' => $contrato,  // Define o contrato ou null (definido fora do loop)
                    'status_manutencao' => false,  // Define status_manutencao como false por padrão
                ];

                // Insere os dados no banco de dados
                Pagamento::create($dados);

                // Adiciona 30 dias ao vencimento para a próxima parcela
                $vencimento->modify('+30 days');
            }

            // Notifica o sucesso da operação
            $this->dispatchNotification('success');

            // Limpa os campos do formulário
            $this->clear();
        } catch (\Throwable $e) {
            // Notifica o erro e exibe a mensagem de erro
            $this->dispatchNotification('error', $e->getMessage());
        }
    }

    public function updateRender() // Atualiza o render do dashboard
    {
        $this->dispatch('updateRender');  // Dispara o evento para atualizar o render
    }

    public function dispatchNotification($type) // Emite notificações
    {
        $this->dispatch($type);  // Dispara o evento de notificação com o tipo fornecido (success ou error)
    }

    public function closeWindow() // Fecha a janela e atualiza as informações
    {
        $this->reset();  // Limpa os campos e estado do componente
        $this->updateRender();  // Atualiza o render após fechar
    }

    public function clear() // Limpa os campos de pagamento
    {
        $this->reset();  // Reseta todas as propriedades do componente
    }

    public function listSuppliers() // Carrega a lista de fornecedores no seletor
    {
        // Obtém todos os fornecedores ordenados alfabeticamente
        $this->listaFornecedores = Fornecedor::orderBy('fornecedor', 'asc')->get();
    }

    #[On('updateRender')] // Dispara a atualização do render após o evento 'updateRender'
    public function render()
    {
        // Carrega a lista de fornecedores
        $this->listSuppliers();

        // Inicializa os campos, garantindo que existam valores para 'valor' e 'nota_fiscal'
        $this->mount();

        // Renderiza a view do componente de inserir pagamento
        return view('livewire.inserir-pagamento');
    }
}
