<?php

namespace App\Livewire;

use App\Models\Pagamento;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarPagamento extends Component
{

    public $id_editarPagamento;
    public $responsavel;
    public $vencimento;
    public $parcela;
    public $nota_fiscal;
    public $valor;
    public $data_pagamento;
    public $data_manutencao;

    #[On('editPaymentById')] // Pega o $id_editarPagamento enviado por dashboard
    public function editPaymentById($id_editarPagamento)
    {
        $this->id_editarPagamento = $id_editarPagamento;
        $this->loadPayment();
    }

    public function dispatchNotification($type) // Emite as mensagens de notificação
    {
        $this->dispatch($type);
    }

    public function delete() // Chama a função para confirmar o delete
    {
        $this->dispatch('deletePaymentMsg',  $this->valor);
    }

    public function paymentDelete() // Deleta o contrato
    {
        $paymentDeleted = Pagamento::destroy($this->id_editarPagamento); // Deleta o registro com o ID especificado

        if ($paymentDeleted) {   // Se o pagamento for deletado
            $this->dispatchNotification('success');
        } else {
            $this->dispatchNotification('error');
        }
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

    public function loadPayment() // Carrega os dados ao alterar o contrato
    {
        $pagamento = Pagamento::find($this->id_editarPagamento);

        if ($pagamento) {
            $this->fill($pagamento->toArray());

            // Formata as datas que foram carregadas, se não forem null
            $this->vencimento = $this->vencimento ? date('d/m/Y', strtotime($this->vencimento)) : '';
            $this->data_pagamento = $this->data_pagamento ? date('d/m/Y', strtotime($this->data_pagamento)) : '';
            $this->data_manutencao = $this->data_manutencao ? date('d/m/Y', strtotime($this->data_manutencao)) : '';

            // Formata o valor que foi carregado
            $this->valor = number_format($this->valor, 2, ',', '.');
        }
    }

    public function render()
    {

        return view('livewire.editar-pagamento');
    }
}
