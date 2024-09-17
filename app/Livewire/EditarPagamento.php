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
    public $cheque;
    public $valor;
    public $data_pagamento;
    public $data_manutencao;
    public $status_manutencao;

    protected $rules = [
        'responsavel' => 'required',  // Campo obrigatório para o responsável
        'vencimento' => 'required',  // Campo obrigatório para a data de vencimento
        'parcela' => 'required',  // Campo obrigatório para a parcela
        'nota_fiscal' => 'required',  // Campo obrigatório para a nota fiscal
        'cheque' => 'nullable|string|max:8',  // Campo opcional, mas se preenchido, deve ser uma string com no máximo 08 caracteres
        'valor' => 'required',  // Campo obrigatório para o valor
        'data_pagamento' => 'nullable|date',  // Campo opcional para data de pagamento, deve ser uma data válida
        'data_manutencao' => 'nullable|date',  // Campo opcional para data de manutenção, deve ser uma data válida
        'status_manutencao' => 'boolean',  // Campo booleano para status de manutenção
    ];

    #[On('editPaymentById')] // Pega o $id_editarPagamento enviado pelo dashboard
    public function editPaymentById($id_editarPagamento)
    {
        $this->id_editarPagamento = $id_editarPagamento;  // Armazena o ID do pagamento a ser editado
        $this->loadPayment();  // Carrega os dados do pagamento
    }

    public function paymentEdit() // Atualiza o pagamento
    {
        try {
            // Valida os dados de acordo com as regras definidas
            $validated = $this->validate();

            // Converte o campo 'responsavel' para uppercase
            $validated['responsavel'] = mb_strtoupper($validated['responsavel'], 'UTF-8');

            // Remove os separadores de milhar e ajusta o formato do valor (de vírgula para ponto)
            $this->valor = str_replace('.', '', $this->valor);  // Remove os pontos
            $this->valor = str_replace(',', '.', $this->valor);  // Substitui vírgulas por pontos
            $validated['valor'] = $this->valor;

            // Verifica se os campos de data estão vazios e os define como null se necessário
            $validated['data_pagamento'] = empty($this->data_pagamento) ? null : $this->data_pagamento;
            $validated['data_manutencao'] = empty($this->data_manutencao) ? null : $this->data_manutencao;

            // Atualiza o pagamento no banco de dados
            Pagamento::find($this->id_editarPagamento)->update([
                'responsavel' => $validated['responsavel'],
                'vencimento' => $this->vencimento,
                'parcela' => $this->parcela,
                'nota_fiscal' => $this->nota_fiscal,
                'cheque' => $this->cheque,
                'valor' => $this->valor,
                'data_pagamento' => $validated['data_pagamento'],
                'data_manutencao' => $validated['data_manutencao'],
                'status_manutencao' => $this->status_manutencao,
            ]);

            // Notifica o sucesso da operação
            $this->dispatchNotification('success');

            // Fecha a janela e limpa os campos do formulário
            $this->closeWindow();
        } catch (\Throwable $e) {
            // Notifica o erro da operação e exibe a mensagem de erro
            $this->dispatchNotification('error', $e->getMessage());
        }
    }

    public function dispatchNotification($type) // Emite as notificações
    {
        // Dispara o evento de notificação com o tipo fornecido
        $this->dispatch($type);
    }

    public function delete() // Chama a função para confirmar o delete
    {
        // Dispara o evento para exibir a mensagem de confirmação de exclusão, passando o valor do pagamento
        $this->dispatch('deletePaymentMsg',  $this->valor);
    }

    public function update() // Chama a função para confirmar a edição
    {
        // Dispara o evento para editar a mensagem do pagamento
        $this->dispatch('editPaymentMsg');
    }

    public function paymentDelete() // Deleta o pagamento
    {
        // Deleta o registro do pagamento pelo ID
        $paymentDeleted = Pagamento::destroy($this->id_editarPagamento);

        // Verifica se o pagamento foi deletado com sucesso e notifica o resultado
        if ($paymentDeleted) {
            $this->dispatchNotification('success');
        } else {
            $this->dispatchNotification('error');
        }
    }

    public function closeWindow() // Fecha a janela e reseta os campos
    {
        $this->reset();  // Limpa as propriedades do componente
        $this->updateRender();  // Atualiza o render após fechar a janela
    }

    public function updateRender() // Atualiza o dashboard
    {
        // Dispara o evento para atualizar o render do dashboard
        $this->dispatch('updateRender');
    }

    public function loadPayment() // Carrega os dados do pagamento para edição
    {
        // Busca o pagamento pelo ID
        $pagamento = Pagamento::find($this->id_editarPagamento);

        if ($pagamento) {
            // Preenche as propriedades com os dados do pagamento
            $this->fill($pagamento->toArray());

            // Formata o valor do pagamento para exibição
            $this->valor = number_format($this->valor, 2, ',', '.');

            // Garante que o status de manutenção seja booleano
            $this->status_manutencao = (bool) $pagamento->status_manutencao;
        }
    }

    public function render()
    {
        // Renderiza a view 'editar-pagamento'
        return view('livewire.editar-pagamento');
    }
}
