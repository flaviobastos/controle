<?php

namespace App\Livewire;

use App\Models\Contrato;
use Livewire\Component;

class InserirContrato extends Component
{

    public $listaContratos;
    public $id_contrato;
    public $contrato; // input text
    public $fornecedor;  // input text
    public $objeto;  // input text
    public $cnpj;  // input text

    protected $rules = [
        'contrato' => 'required|string|max:11',
        'fornecedor' => 'required|string|max:50',
        'objeto' => 'required|string|max:200',
        'cnpj' => 'required|string|max:18',
    ];

    public function clear() // Limpar os campos de cadastro
    {
        $this->reset();
    }

    public function closeWindow() // Atualiza as informações ao fechar a janela
    {
        $this->reset();
        $this->updateRender();
    }

    public function updateRender() // Atualiza o dashboard
    {
        $this->dispatch('updateRender');
    }

    public function dispatchNotification($type) // Emite as mensagens de notificação
    {
        $this->dispatch($type);
    }

    public function changeContract() // Carrega os dados ao alterar o contrato
    {
        if (empty($this->id_contrato)) {
            $this->clear();
            return;
        }

        $contrato = Contrato::find($this->id_contrato);

        if ($contrato) {
            $this->fill($contrato->toArray());
        }
    }

    public function listContracts() // Carrega a lista de contratos no seletor
    {
        $this->listaContratos = Contrato::orderBy('fornecedor', 'asc')->get();
    }

    public function save() // Chama a função para salvar ou atualizar o contrato
    {
        $validated = $this->validate();
        $this->processContractCreation($validated);
    }

    public function delete() // Chama a função para confirmar o delete
    {
        $this->dispatch('deleteContractMsg',  $this->contrato);
    }

    public function processContractCreation($validated) // Verifica se o contrato já existe
    {
        // Verifica se o contrato já existe
        $existingContract = Contrato::where('contrato', $validated['contrato'])->first();

        if ($existingContract) {
            // Se o contrato já existir, exibe uma mensagem em SweetAlert2
            $this->dispatch('existingContract',  $this->contrato);
        } else {
            $this->contractCreate($validated);
        }
    }

    public function contractCreate($validated) // Cria os dados após validação
    {
        if (Contrato::create($validated)) {
            $this->dispatchNotification('success');
        } else {
            $this->dispatchNotification('error');
        }
        $this->clear();
    }

    public function contractUpdate() // Atualiza os dados após validação
    {
        $validated = $this->validate();
        $contrato = Contrato::where('contrato', $validated['contrato'])->first();

        if ($contrato) {
            $contrato->update($validated);
            $this->dispatchNotification('success');
        } else {
            $this->dispatchNotification('error');
        }
        $this->clear();
    }

    public function contractDelete() // Deleta o contrato
    {
        $contractDeleted = Contrato::destroy($this->id_contrato); // Deleta o registro com o ID especificado

        if ($contractDeleted) {   // Se o contrato for deletado
            $this->dispatchNotification('success');
        } else {
            $this->dispatchNotification('error');
        }
        $this->clear();
    }

    public function render() // Renderiza a página
    {
        $this->listContracts();
        return view('livewire.inserir-contrato');
    }
}
