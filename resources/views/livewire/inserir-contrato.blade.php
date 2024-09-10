    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Imagem de Loading -->
        <img wire:loading src="{{ asset('/images/loading.gif') }}" class="w-40 fixed inset-0 mx-auto my-auto z-50"
            alt="Loading">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <p class="text-lg font-semibold text-gray-900">
                    Cadastrar Contrato
                </p>
                <button type="button" wire:click="closeWindow" x-on:click="inserirContrato=false"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Fechar</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4">
                <div class="grid gap-4 mb-4 grid-cols-2">

                    <div class="col-span-2">
                        <label for="selecionar_contrato" class="block mb-2 text-sm font-medium text-gray-900">Selecionar
                            Contrato / Fornecedor</label>
                        <select id="selecionar_contrato" wire:model.live="id_contrato" wire:change="changeContract"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="" selected=""Ï>Cadastrar Novo Contrato</option>
                            @foreach ($listaContratos as $contrato)
                                <option value="{{ $contrato->id }}">
                                    {{ $contrato->contrato . ' - ' . $contrato->fornecedor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="fornecedor" class="block mb-2 text-sm font-medium text-gray-900">Razão Social do
                            Fornecedor</label>
                        <input type="text" name="fornecedor" id="fornecedor" wire:model.defer="fornecedor"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 uppercase"
                            placeholder="Digite o nome do fornecedor" required="" maxlength="50">
                    </div>

                    <div class="col-span-2">
                        <label for="objeto" class="block mb-2 text-sm font-medium text-gray-900">Objeto do
                            Contrato</label>
                        <textarea id="objeto" rows="4" style="resize:none" wire:model.defer="objeto"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase"
                            placeholder="Escreva o objeto do contrato" required="" maxlength="200"></textarea>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="contrato" class="block mb-2 text-sm font-medium text-gray-900">Número do
                            Contrato</label>
                        <input type="text" name="contrato" id="contrato" wire:model.defer="contrato"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="00000000000" required="" maxlength="11" x-mask="99999999999">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="cnpj" class="block mb-2 text-sm font-medium text-gray-900">CNPJ do
                            Fornecedor</label>
                        <input type="text" name="cnpj" id="cnpj" wire:model.defer="cnpj"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="00.000.000/0000-00" required="" maxlength="18" x-mask="99.999.999/9999-99">
                    </div>

                </div>

                <div class="flex flex-row items-center justify-between">

                    <button type="button" wire:click="clear"
                        class="text-white inline-flex items-center bg-emerald-500 hover:bg-emerald-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff"
                            viewBox="0 0 256 256" class="mr-2">
                            <path
                                d="M225,80.4,183.6,39a24,24,0,0,0-33.94,0L31,157.66a24,24,0,0,0,0,33.94l30.06,30.06A8,8,0,0,0,66.74,224H216a8,8,0,0,0,0-16h-84.7L225,114.34A24,24,0,0,0,225,80.4ZM108.68,208H70.05L42.33,180.28a8,8,0,0,1,0-11.31L96,115.31,148.69,168Zm105-105L160,156.69,107.31,104,161,50.34a8,8,0,0,1,11.32,0l41.38,41.38a8,8,0,0,1,0,11.31Z">
                            </path>
                        </svg>
                        Limpar
                    </button>

                    @if (!empty($this->id_contrato))
                        <button type="button" wire:click="delete"
                            class="text-white inline-flex items-center bg-red-600 hover:bg-red-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff"
                                viewBox="0 0 256 256" class="mr-2">
                                <path
                                    d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z">
                                </path>
                            </svg>
                            Excluir
                        </button>
                    @endif

                    <button type="button" wire:click="save"
                        class="text-white inline-flex items-center bg-blue-500 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff"
                            viewBox="0 0 256 256" class="mr-2">
                            <path
                                d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                            </path>
                        </svg>
                        Salvar
                    </button>

                </div>
            </form>
        </div>
    </div>

    <script>
        function handleContractAction(eventType, title, icon, confirmText, cancelText, htmlContent, actionMethod) {
            window.addEventListener(eventType, function(e) {
                var contractNumber = e.detail; // Obtém o valor do evento
                Swal.fire({
                    title: title,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText,
                    reverseButtons: true,
                    html: htmlContent.replace('{contractNumber}',
                        contractNumber), // Substitui o valor no conteúdo HTML
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call(actionMethod);
                    }
                });
            });
        }

        // Configurações específicas para cada evento

        handleContractAction(
            'existingContract',
            'Tem certeza disso?',
            'question',
            'Sim, atualizar',
            'Não, cancelar',
            'Os dados referentes ao <strong>Contrato nº {contractNumber}</strong> serão substituídos.',
            'contractUpdate'
        );

        handleContractAction(
            'deleteContractMsg',
            'Tem certeza disso?',
            'warning',
            'Sim, excluir',
            'Não, cancelar',
            'Os dados referentes ao <strong>Contrato nº {contractNumber}</strong> serão excluídos permanentemente.',
            'contractDelete'
        );
    </script>
