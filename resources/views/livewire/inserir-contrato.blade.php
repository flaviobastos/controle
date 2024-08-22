    <!-- Main modal -->
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Cadastrar Contrato
                </h3>
                <button type="button" wire:click="clear" x-on:click="inserirContrato=false"
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
            <form class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">

                    <div class="col-span-2">
                        <label for="selecionar_contrato" class="block mb-2 text-sm font-medium text-gray-900">Selecionar
                            Contrato</label>
                        <select id="selecionar_contrato"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="" selected=""Ï>Cadastrar Novo Contrato</option>
                            @foreach ($listaContratos as $contrato)
                                <option value="{{ $contrato->id }}">{{ $contrato->fornecedor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="fornecedor" class="block mb-2 text-sm font-medium text-gray-900">Razão Social do
                            Fornecedor</label>
                        <input type="text" name="fornecedor" id="fornecedor" wire:model.defer="fornecedor"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Digite o nome do fornecedor" required="" maxlength="30">
                    </div>

                    <div class="col-span-2">
                        <label for="objeto" class="block mb-2 text-sm font-medium text-gray-900">Objeto do
                            Contrato</label>
                        <textarea id="objeto" rows="4" style="resize:none" wire:model.defer="objeto"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Escreva o objeto do contrato" required="" maxlength="50"></textarea>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="contrato" class="block mb-2 text-sm font-medium text-gray-900">Número do
                            Contrato</label>
                        <input type="text" name="contrato" id="contrato" wire:model.defer="contrato"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="N. Contrato" required="" maxlength="11">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="cnpj" class="block mb-2 text-sm font-medium text-gray-900">CNPJ do
                            Fornecedor</label>
                        <input type="text" name="cnpj" id="cnpj" wire:model.defer="cnpj"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Digite o CNPJ" required="" maxlength="18">
                    </div>

                </div>

                <div class="flex flex-row items-center justify-end">
                    <button type="button" wire:click="save"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
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
