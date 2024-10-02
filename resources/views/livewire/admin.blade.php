<div class="bg-gray-200 flex flex-col items-center justify-center h-screen">
    <div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 text-center mb-6">Gerenciar Usuários
            <p>{{ Auth::user()->email }}
            </p>
        </h2>

        <!-- Formulário de criação de novo usuário -->
        <form>
            <!-- Nome -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Nome do Novo Usuário</label>
                <input wire:model.defer="name" type="text" id="name" name="name" placeholder="Nome completo"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input wire:model.defer="email" type="email" id="email" name="email"
                    placeholder="email@example.com"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Senha -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Senha</label>
                <input wire:model.defer="password" type="password" id="password" name="password"
                    placeholder="Digite uma senha"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Checkbox de administrador -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input wire:model.defer="is_admin" type="checkbox" name="is_admin"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">Conceder privilégios de administrador</span>
                </label>
            </div>

            <button wire:click="createNewUser" type="button"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none">Criar Novo
                Usuário</button>
        </form>

        <hr class="my-6">

        <!-- Formulário de alteração de senha de usuários existentes -->
        <form>
            <!-- Seletor de usuários -->
            <div class="mb-4">
                <label for="user" class="block text-gray-700 font-medium mb-2">Selecione o Usuário</label>
                <select id="user" name="user" wire:model.live="id_usuario" wire:change="loadStatus"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected>Escolha um usuário</option>
                    @foreach ($listaUsuarios as $usuarios)
                        <option value="{{ $usuarios->id }}">
                            {{ $usuarios->name }} ({{ $usuarios->email }}) </option>
                    @endforeach
                </select>
            </div>

            <!-- Nova senha -->
            <div class="mb-4">
                <label for="new_password" class="block text-gray-700 font-medium mb-2">Nova Senha (Deixe em branco se
                    não quiser alterar)</label>
                <input wire:model.defer="new_password" type="password" id="new_password" name="new_password"
                    placeholder="Digite uma nova senha"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Checkbox de administrador -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input wire:model.live="status_usuario" type="checkbox" name="is_admin_edit"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">Alterar privilégios de administrador</span>
                </label>
            </div>

            <button wire:click="updateUser" type="button"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Alterar
                Senha e Privilégios</button>

            <button wire:click="deleteUser" type="button"
                class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 mt-4">Excluir
                Usuário</button>

        </form>
    </div>
</div>
