<?php

namespace App\Livewire;

use App\Models\Contrato;
use App\Models\Pagamento;
use Livewire\Attributes\On;
use Livewire\Component;

class InserirPagamento extends Component
{
    public $listaContratos;
    public $contrato_id;
    public $responsavel; // Campo do formulário
    public $vencimento; // Campo do formulário
    public $parcela = 1; // Campo do formulário
    public $valor = []; // Campo do formulário
    public $nota_fiscal = []; // Campo do formulário

    protected $rules = [
        'responsavel' => 'required',
        'vencimento' => 'required',
        'parcela' => 'required',
        'nota_fiscal' => 'required',
        'valor' => 'required',
        // 'data_pagamento' => 'nullable|date',
        // 'data_manutencao' => 'nullable|date',
    ];

    public function updatedParcela($qtdParcelas) // É chamado quando há atualização na variável $parcela
    {
        $qtdParcelas = max(1, intval($qtdParcelas)); // Garantir que o valor seja pelo menos 1
        $this->parcela = $qtdParcelas;

        // Ajusta os arrays $valor e $nota_fiscal de acordo com o número de parcelas
        $this->valor = array_pad(array_slice($this->valor, 0, $this->parcela), $this->parcela, '');
        $this->nota_fiscal = array_pad(array_slice($this->nota_fiscal, 0, $this->parcela), $this->parcela, '');
    }

    public function mount()
    {
        // Garantir que ao montar o componente sempre exista pelo menos um campo
        if (count($this->valor) < 1) {
            $this->valor[] = '';
        }

        if (count($this->nota_fiscal) < 1) {
            $this->nota_fiscal[] = '';
        }
    }

    public function save() // Salva o pagamento
    {
        try {
            // Valida os dados
            $validated = $this->validate();

            // Adiciona o contrato_id validado
            $validated['contrato_id'] = $this->contrato_id;

            // Remove os separadores de milhar (pontos) e converte a vírgula decimal para ponto
            $this->valor = str_replace('.', '', $this->valor); // Remove os pontos
            $this->valor = str_replace(',', '.', $this->valor); // Converte a vírgula decimal para ponto
            $validated['valor'] = $this->valor;

            $vencimento = new \DateTime($this->vencimento);

            // Itera sobre as parcelas e salva cada uma como uma linha separada no banco de dados
            foreach ($this->nota_fiscal as $index => $notaFiscal) {
                // Cria um novo array de dados para cada linha
                $dados = [
                    'responsavel' => $validated['responsavel'],
                    'vencimento' => $vencimento, // Define o vencimento para esta parcela
                    'parcela' => $index + 1, // Índice baseado em 1 para a parcela
                    'nota_fiscal' => $notaFiscal,
                    'valor' => $this->valor[$index],
                    'contrato_id' => $validated['contrato_id'], // Inclui o contrato_id
                ];

                // Salva cada linha no banco de dados
                Pagamento::create($dados);

                // Adiciona 30 dias para o próximo vencimento
                $vencimento->modify('+30 days');
            }

            // Notifica o usuário sobre o sucesso da operação
            $this->dispatchNotification('success');

            // Limpa os campos do formulário
            $this->clear();
        } catch (\Throwable $e) {
            // Notifica o usuário sobre o erro na operação
            $this->dispatchNotification('error', $e->getMessage());
        }
    }

    public function updateRender() // Atualiza o dashboard e lista de contratos
    {
        $this->dispatch('updateRender');
    }

    public function dispatchNotification($type)
    {
        $this->dispatch($type);
    }

    public function closeWindow() // Atualiza as informações ao fechar a janela
    {
        $this->reset();
        $this->updateRender();
    }

    public function clear() // Limpar os campos de pagamento
    {
        $this->reset();
    }

    public function listContracts() // Carrega a lista de contratos no seletor
    {
        $this->listaContratos = Contrato::orderBy('fornecedor', 'asc')->get();
    }

    #[On('updateRender')] // Atualiza o render após atualizações
    public function render()
    {
        $this->listContracts();
        $this->mount();
        return view('livewire.inserir-pagamento');
    }
}
