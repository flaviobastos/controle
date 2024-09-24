<?php

namespace App\Livewire;

use App\Models\Fornecedor;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InserirFornecedor extends Component
{

    public $listaFornecedores;
    public $id_fornecedor;
    public $fornecedor;  // input text
    public $objeto;  // input text
    public $cnpj;  // input text
    public $emailUsuario;
    public $ipUsuario;

    protected $rules = [
        'fornecedor' => 'required|string|max:50',  // Valida que o campo fornecedor é obrigatório, uma string e com no máximo 50 caracteres
        'objeto' => 'required|string|max:200',  // Valida que o campo objeto é obrigatório, uma string e com no máximo 200 caracteres
        'cnpj' => 'required|string|max:18',  // Valida que o campo CNPJ é obrigatório, uma string e com no máximo 18 caracteres
    ];

    public function userMail()
    {
        if (Auth::check()) {
            $this->emailUsuario = Auth::user()->email; // Acessa o e-mail do usuário logado
            $this->ipUsuario = request()->ip();  // Adiciona o IP do usuário ao log
        }
    }

    public function clear() // Limpa os campos de cadastro
    {
        $this->reset();  // Reseta todas as propriedades do componente
    }

    public function closeWindow() // Fecha a janela e atualiza as informações
    {
        $this->reset();  // Reseta todas as propriedades
        $this->updateRender();  // Chama a atualização do render do dashboard
    }

    public function updateRender() // Atualiza o dashboard
    {
        $this->dispatch('updateRender');  // Dispara o evento para atualizar o render do dashboard
    }

    public function dispatchNotification($type) // Emite mensagens de notificação
    {
        // Dispara o evento de notificação com o tipo fornecido (por exemplo, 'success' ou 'error')
        $this->dispatch($type);
    }

    public function changeSupplier() // Carrega os dados ao alterar o fornecedor
    {
        // Se o ID do fornecedor estiver vazio, limpa os campos
        if (empty($this->id_fornecedor)) {
            $this->clear();
            return;
        }

        // Busca o fornecedor pelo ID fornecido
        $fornecedor = Fornecedor::find($this->id_fornecedor);

        if ($fornecedor) {
            // Preenche os campos do componente com os dados do fornecedor
            $this->fill($fornecedor->toArray());
        }
    }

    public function listSuppliers() // Carrega a lista de fornecedores no seletor
    {
        // Obtém todos os fornecedores ordenados alfabeticamente
        $this->listaFornecedores = Fornecedor::orderBy('fornecedor', 'asc')->get();
    }

    public function save() // Salva ou atualiza o fornecedor após validação
    {
        // Valida os dados conforme as regras
        $validated = $this->validate();

        // Converte os campos para uppercase usando mb_strtoupper() com encoding UTF-8
        $validated['fornecedor'] = mb_strtoupper($validated['fornecedor'], 'UTF-8');
        $validated['objeto'] = mb_strtoupper($validated['objeto'], 'UTF-8');

        // Processa a criação ou atualização do fornecedor
        $this->processSupplierCreation($validated);
    }

    public function delete() // Confirma a exclusão do fornecedor
    {
        // Dispara o evento para exibir a mensagem de confirmação de exclusão, passando o nome do fornecedor
        $this->dispatch('deleteSupplierMsg',  $this->fornecedor);
    }

    public function processSupplierCreation($validated) // Verifica se o fornecedor já existe
    {
        // Verifica se o fornecedor já existe com base no CNPJ
        $existingSupplier = Fornecedor::where('cnpj', $validated['cnpj'])->first();

        if ($existingSupplier) {
            // Se o fornecedor já existir, dispara uma mensagem informando ao usuário
            $this->dispatch('existingSupplierMsg',  $this->fornecedor);
        } else {
            // Se não existir, cria um novo fornecedor
            $this->supplierCreate($validated);
        }
    }

    public function supplierCreate($validated) // Cria o fornecedor após validação
    {
        // Cria o fornecedor com os dados validados e notifica o resultado
        if (Fornecedor::create($validated)) {
            $this->dispatchNotification('success');  // Notifica sucesso

            // Grava uma mensagem de sucesso no log
            Log::create([
                'usuario' => $this->emailUsuario,
                'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
                'mensagem' => 'Fornecedor criado com sucesso',
            ]);
        } else {
            $this->dispatchNotification('error');  // Notifica erro
        }
        $this->clear();  // Limpa os campos do formulário
    }

    public function supplierUpdate() // Atualiza os dados do fornecedor após validação
    {
        // Valida os dados conforme as regras
        $validated = $this->validate();

        // Converte os campos para uppercase usando mb_strtoupper() com encoding UTF-8
        $validated['fornecedor'] = mb_strtoupper($validated['fornecedor'], 'UTF-8');
        $validated['objeto'] = mb_strtoupper($validated['objeto'], 'UTF-8');

        // Busca o fornecedor com base no CNPJ fornecido
        $fornecedor = Fornecedor::where('cnpj', $validated['cnpj'])->first();

        if ($fornecedor) {
            // Atualiza o fornecedor com os dados validados e notifica o resultado
            $fornecedor->update($validated);
            $this->dispatchNotification('success');  // Notifica sucesso

            // Grava uma mensagem de sucesso no log
            Log::create([
                'usuario' => $this->emailUsuario,
                'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
                'mensagem' => 'Fornecedor atualizado com sucesso',
            ]);
        } else {
            $this->dispatchNotification('error');  // Notifica erro
        }
        $this->clear();  // Limpa os campos do formulário
    }

    public function supplierDelete() // Deleta o fornecedor
    {

        // Deleta o fornecedor pelo ID e notifica o resultado
        $supplierDeleted = Fornecedor::destroy($this->id_fornecedor);

        if ($supplierDeleted) {
            // Se o fornecedor for deletado com sucesso, notifica sucesso
            $this->dispatchNotification('success');

            // Grava uma mensagem de sucesso no log
            Log::create([
                'usuario' => $this->emailUsuario,
                'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
                'mensagem' => 'Fornecedor excluído com sucesso',
            ]);
        } else {
            // Se falhar, notifica erro
            $this->dispatchNotification('error');
        }
        $this->clear();  // Limpa os campos do formulário
    }

    public function render() // Renderiza a página
    {
        $this->listSuppliers(); // Carrega a lista de fornecedores

        $this->userMail(); // Obter o e-mail do usuário logado para log

        return view('livewire.inserir-fornecedor');  // Renderiza a view 'inserir-fornecedor'
    }
}
