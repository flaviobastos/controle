<div>
    <!-- Imagem de Loading -->
    <img wire:loading src="{{ asset('/images/loading.gif') }}" class="w-40 fixed inset-0 mx-auto my-auto z-50"
        alt="Loading">
    <section class="bg-gray-200">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-3xl font-light text-gray-900">
                Controle de Pagamentos
            </a>
            <div class="w-full bg-white rounded-lg shadow max-w-sm">
                <div class="p-6 space-y-4">
                    <h1 class="text-xl text-center font-light leading-tight tracking-tight text-gray-900">
                        Acesse com sua conta
                    </h1>
                    <hr>
                    <form class="space-y-4" action="#">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Seu email</label>
                            <input type="email" name="email" id="email" wire:model.defer="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="name@company.com" required="" maxlength="30">
                        </div>
                        @error('email')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Senha</label>
                            <input type="password" name="password" id="password" wire:model.defer="password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required="" maxlength="20">
                        </div>
                        @error('password')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" aria-describedby="remember" type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300"
                                        required="">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500">Lembrar de mim</label>
                                </div>
                            </div>
                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline">Esqueceu sua
                                senha?</a>
                        </div>
                        <button type="submit" wire:click="login"
                            onclick="this.disabled = true; this.style.backgroundColor = '#515A5A'; this.style.cursor='wait'; setTimeout(() => this.disabled = false, 5000)"
                            class="w-full text-white bg-blue-600 hover:bg-blue-800 duration-300 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Acessar
                            sua conta</button>
                        <p class="text-sm font-light text-gray-500">
                            Ainda não tem acesso? <a href="#"
                                class="font-medium text-primary-600 hover:underline">Solicitar</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
