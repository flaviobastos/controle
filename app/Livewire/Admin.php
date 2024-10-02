<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Admin extends Component
{
    public $listaUsuarios;
    public $status_usuario;
    public $id_usuario;
    public $new_password;
    public $name;
    public $email;
    public $password;
    public $is_admin = false;
    public $emailUsuario;
    public $ipUsuario;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'is_admin' => 'boolean',
    ];

    protected function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Digite um endereço de e-mail válido.',
            'email.unique' => 'E-mail já cadastrado.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ];
    }

    public function mount()
    {
        if (!Auth::user()->is_admin) {
            // Se o usuário não for admin, redireciona para o dashboard
            return redirect()->route('dashboard');
        }
    }

    public function userMail() // Obter o e-mail do usuário logado para log
    {
        if (Auth::check()) {
            $this->emailUsuario = Auth::user()->email; // Acessa o e-mail do usuário logado
            $this->ipUsuario = request()->ip();  // Adiciona o IP do usuário ao log
        }
    }

    public function dispatchNotification($type) // Emite mensagens de notificação
    {
        // Dispara o evento de notificação com o tipo fornecido (por exemplo, 'success' ou 'error')
        $this->dispatch($type);
    }

    public function listUsers() // Carrega a lista de usuários no seletor
    {
        // Obtém todos os usuários ordenados alfabeticamente
        $this->listaUsuarios = User::orderBy('email', 'asc')->get();
    }

    public function clear() // Limpa os campos de cadastro
    {
        $this->reset();  // Reseta todas as propriedades do componente
    }

    public function loadStatus() // Carrega o status do privilégio do usuário
    {

        // Se o ID do usuario estiver vazio, limpa os campos
        if (empty($this->id_usuario)) {
            $this->clear();
            return;
        }

        // Busca o usuário pelo ID
        $status = User::find($this->id_usuario);

        if ($status) {
            // Preenche as propriedades com os dados do usuário
            // $this->fill($status->toArray());

            // Garante que o status de usuário seja booleano
            $this->status_usuario = (bool) $status->is_admin;
        }
    }

    public function createNewUser()
    {
        // Valida os dados
        $this->validate();

        // Verifica se o email já existe no banco de dados
        if (User::where('email', $this->email)->exists()) {
            // Exibe uma mensagem de erro se o email já estiver cadastrado
            $this->dispatchNotification('error');
            return;
        }

        // Cria o usuário se o email não existir
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => $this->is_admin,
        ]);

        // Grava uma mensagem de sucesso no log
        Log::create([
            'usuario' => $this->emailUsuario,
            'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
            'mensagem' => 'Usuário cadastrado com sucesso',
        ]);

        // Reseta os campos do formulário
        $this->reset();

        // Exibe uma mensagem de sucesso
        $this->dispatchNotification('success');
    }

    public function deleteUser() // Deleta o fornecedor
    {

        // Deleta o usuário pelo ID e notifica o resultado
        $delete = User::destroy($this->id_usuario);

        if ($delete) {
            // Se o usuário for deletado com sucesso, notifica sucesso
            $this->dispatchNotification('success');

            // Grava uma mensagem de sucesso no log
            Log::create([
                'usuario' => $this->emailUsuario,
                'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
                'mensagem' => 'Usuário excluído com sucesso',
            ]);
        } else {
            // Se falhar, notifica erro
            $this->dispatchNotification('error');
        }
        $this->clear();  // Limpa os campos do formulário
    }

    public function updateUser()
    {
        // Valida os dados
        $this->validate([
            'id_usuario' => 'required|exists:users,id',
            'new_password' => 'nullable|min:6',
        ]);

        // Atualiza o usuário diretamente com o método update
        User::where('id', $this->id_usuario)->update([
            'password' => $this->new_password ? Hash::make($this->new_password) : User::find($this->id_usuario)->password,
            'is_admin' => $this->status_usuario,
        ]);

        // Exibe uma notificação de sucesso
        $this->dispatchNotification('success', 'Usuário atualizado com sucesso!');

        // Grava uma mensagem de sucesso no log
        Log::create([
            'usuario' => $this->emailUsuario,
            'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
            'mensagem' => 'Usuário atualizado com sucesso',
        ]);

        $this->clear();  // Limpa os campos do formulário
    }

    public function render()
    {
        $this->listUsers(); // Carrega a lista de usuarios
        $this->userMail(); // Obter o e-mail do usuário logado para log

        return view('livewire.admin');
    }
}
