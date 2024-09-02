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

    protected $rules = [
        'responsavel' => 'required',
        'vencimento' => 'required',
        'parcela' => 'required',
        'nota_fiscal' => 'required',
        'valor' => 'required',
        'data_pagamento' => 'nullable|date',
        'data_manutencao' => 'nullable|date',
    ];

    public function paymentEdit() // Atualiza o pagamento
    {
        try {
            // Valida os dados
            $validated = $this->validate();

            // Remove os separadores de milhar (pontos) e converte a vírgula decimal para ponto
            $this->valor = str_replace('.', '', $this->valor); // Remove os pontos
            $this->valor = str_replace(',', '.', $this->valor); // Converte a vírgula decimal para ponto
            $validated['valor'] = $this->valor;

            Pagamento::find($this->id_editarPagamento)->update([
                'responsavel' => $validated['responsavel'],
                'vencimento' => $this->vencimento,
                'parcela' => $this->parcela, // Índice baseado em 1 para a parcela
                'nota_fiscal' => $this->nota_fiscal,
                'valor' => $this->valor,
                'data_pagamento' => $this->data_pagamento,
                'data_manutencao' => $this->data_manutencao,
            ]);

            // Notifica o usuário sobre o sucesso da operação
            $this->dispatchNotification('success');

            // Limpa os campos do formulário
            $this->closeWindow();
        } catch (\Throwable $e) {
            // Notifica o usuário sobre o erro na operação
            $this->dispatchNotification('error', $e->getMessage());
        }
    }

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

    public function update() // Chama a função para confirmar o delete
    {
        $this->dispatch('editPaymentMsg');
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
            // Formata o valor que foi carregado
            $this->valor = number_format($this->valor, 2, ',', '.');
        }
    }

    public function render()
    {

        return view('livewire.editar-pagamento');
    }
}
