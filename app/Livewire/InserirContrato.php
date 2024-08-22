<?php

namespace App\Livewire;

use App\Models\Contrato;
use Livewire\Component;

class InserirContrato extends Component
{
    public $contrato;
    public $listaContratos;
    public $fornecedor;
    public $objeto;
    public $cnpj;

    protected $rules = [
        'contrato' => 'required',
        'fornecedor' => 'required',
        'objeto' => 'required',
        'cnpj' => 'required',
    ];

    public function clear()
    {
        $this->reset();
    }

    public function dispatchSuccess()
    {
        $this->dispatch('success');
    }

    public function handleError()
    {
        $this->dispatch('error');
    }

    public function save()
    {
        $this->processContractCreation();
    }

    public function listaContratos()
    {
        $this->listaContratos = Contrato::orderBy('fornecedor', 'asc')->get();
    }

    private function processContractCreation()
    {
        $validated = $this->validate();

        if (Contrato::create($validated)) {
            $this->dispatchSuccess();
        } else {
            $this->handleError();
        }

        $this->clear();
    }

    public function render()
    {
        $this->listaContratos();

        return view('livewire.inserir-contrato');
    }
}
