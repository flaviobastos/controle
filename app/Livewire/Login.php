<?php

namespace App\Livewire;

use App\Models\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $email;  // Armazena o e-mail inserido pelo usuário
    public $password;  // Armazena a senha inserida pelo usuário
    public $emailUsuario; // Armazena o login do usuario
    public $ipUsuario; // Armazena o IP do usuario

    protected array $rules = [
        // Validações para o campo e-mail: obrigatório, deve ser um e-mail válido, mínimo de 5 e máximo de 30 caracteres
        'email' => 'required|email|min:5|max:30',

        // Validações para o campo senha: obrigatório, mínimo de 5 e máximo de 20 caracteres
        'password' => 'required|min:5|max:20',
    ];

    public function userMail()
    {
        if (Auth::check()) {
            $this->emailUsuario = Auth::user()->email; // Acessa o e-mail do usuário logado
            $this->ipUsuario = request()->ip();  // Adiciona o IP do usuário ao log
        }
    }

    protected array $messages = [
        // Mensagem de erro quando o e-mail é obrigatório
        'email.required' => 'O campo e-mail é obrigatório.',

        // Mensagem de erro quando o e-mail tem menos de 5 caracteres
        'email.min' => 'O campo de e-mail deve ter pelo menos 5 caracteres.',

        // Mensagem de erro quando o e-mail excede o limite de 30 caracteres
        'email.max' => 'O campo de e-mail não deve ter mais de 30 caracteres.',

        // Mensagem de erro quando a senha é obrigatória
        'password.required' => 'O campo senha é obrigatório.',

        // Mensagem de erro quando a senha tem menos de 5 caracteres
        'password.min' => 'O campo de senha deve ter pelo menos 5 caracteres.',

        // Mensagem de erro quando a senha excede o limite de 20 caracteres
        'password.max' => 'O campo de senha não deve ter mais de 20 caracteres.',
    ];

    public function login() // Método para realizar o login
    {
        // Valida os dados com base nas regras definidas
        $validatedData = $this->validate();

        // Verifica se as credenciais estão corretas usando o método Auth::attempt
        if (Auth::attempt($validatedData)) {
            // Se a autenticação for bem-sucedida, regenera a sessão para evitar ataques de fixação de sessão
            session()->regenerate();

            $this->userMail(); // Obter o e-mail do usuário logado para log

            // Grava uma mensagem de sucesso no log
            Log::create([
                'usuario' => $this->emailUsuario,
                'ip' => $this->ipUsuario,  // Adiciona o IP do usuário ao log
                'mensagem' => 'Logado no sistema com sucesso',
            ]);

            // Redireciona o usuário para o dashboard após o login bem-sucedido
            return redirect()->route('dashboard');
        }

        // Se a autenticação falhar, dispara um evento de falha no login
        $this->dispatch('loginFailed');
        $this->password = '';  // Limpa a senha para evitar que ela permaneça no campo
    }

    #[Layout('components.layouts.login-layout')]  // Define o layout usado para a página de login
    public function render()
    {
        // Renderiza a view de login localizada em 'livewire.login'
        return view('livewire.login');
    }
}
