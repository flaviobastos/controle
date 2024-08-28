<?php

namespace App\Livewire;

use App\Models\Contrato;
use App\Models\Pagamento;
use Livewire\Component;

class InserirPagamento extends Component
{
    public $listaContratos;
    public $contrato_id;
    public $responsavel;
    public $vencimento;
    public $parcela;
    public $nota_fiscal;
    public $valor;
    public $data_pagamento;
    public $data_manutencao;

    protected $rules = [
        'responsavel' => 'required|string|max:30',
        'vencimento' => 'required|date',
        'parcela' => 'required|string|max:5',
        'nota_fiscal' => 'required|string|max:5',
        'valor' => 'required|max:14',
        'data_pagamento' => 'nullable|date',
        'data_manutencao' => 'nullable|date',
    ];

    public function save() // Salva o pagamento
    {
        // Valida os dados
        $validated = $this->validate();

        // Adiciona o contrato_id aos dados validados
        $validated['contrato_id'] = $this->contrato_id;

        // Remove os separadores de milhar (pontos) e converte a vírgula decimal para ponto
        $this->valor = str_replace('.', '', $this->valor); // Remove os pontos
        $this->valor = str_replace(',', '.', $this->valor); // Converte a vírgula decimal para ponto
        $validated['valor'] = $this->valor;

        // Converte a data de 'dd/mm/yyyy' para 'yyyy-mm-dd' para ser aceita pelo banco de dados
        $validated['vencimento'] = \DateTime::createFromFormat('d/m/Y', $this->vencimento)->format('Y-m-d');

        // Assegura que os campos data_pagamento e data_manutencao estejam presentes
        $validated['data_pagamento'] = $this->data_pagamento ?? null;
        $validated['data_manutencao'] = $this->data_manutencao ?? null;

        // Salva os dados no banco
        if (Pagamento::create($validated)) {
            $this->dispatchNotification('success');
        } else {
            $this->dispatchNotification('error');
        }

        // Limpa os campos do formulário
        $this->clear();
    }

    public function dispatchNotification($type)
    {
        $this->dispatch($type);
    }

    public function clear() // Limpar os campos de cadastro
    {
        $this->reset();
    }

    public function listContracts() // Carrega a lista de contratos no seletor
    {
        $this->listaContratos = Contrato::orderBy('fornecedor', 'asc')->get();
    }

    public function render()
    {
        if (!$this->listaContratos) {
            $this->listContracts();
        }

        return view('livewire.inserir-pagamento');
    }
}
