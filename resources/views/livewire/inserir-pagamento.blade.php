    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Imagem de Loading -->
        <img wire:loading src="{{ asset('/images/loading.gif') }}" class="w-40 fixed inset-0 mx-auto my-auto z-50"
            alt="Loading">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <p class="text-lg font-semibold text-gray-900">
                    Inserir Pagamento
                </p>
                <button type="button" wire:click="closeWindow" x-on:click="inserirPagamento=false"
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
                        <label for="contrato_id" class="block mb-2 text-sm font-medium text-gray-900">Selecionar
                            Contrato / Fornecedor</label>
                        <select id="contrato_id" wire:model.live="contrato_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="" selected=""Ï>Selecione o Contrato</option>
                            @foreach ($listaContratos as $contrato)
                                <option value="{{ $contrato->id }}">
                                    {{ $contrato->contrato . ' - ' . $contrato->fornecedor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="responsavel"
                            class="block mb-2 text-sm font-medium text-gray-900">Responsável</label>
                        <input type="text" name="responsavel" id="responsavel" wire:model.defer="responsavel"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Responsável pelo serviço ou material" required="" maxlength="30">
                    </div>

                    <div class="col-span-1">
                        <label for="vencimento" class="block mb-2 text-sm font-medium text-gray-900">Vencimento</label>
                        <input name="vencimento" id="vencimento" wire:model.defer="vencimento"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="{{ date('d/m/Y') }}" required="" x-mask="99/99/9999">
                    </div>

                    <div class="col-span-1">
                        <label for="parcela" class="block mb-2 text-sm font-medium text-gray-900">Parcela</label>
                        <input type="text" name="parcela" id="parcela" wire:model.defer="parcela"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="00/00" required="" maxlength="5" x-mask="99/99">
                    </div>

                    <div class="col-span-1">
                        <label for="nota_fiscal" class="block mb-2 text-sm font-medium text-gray-900">Nota
                            Fiscal</label>
                        <input type="text" name="nota_fiscal" id="nota_fiscal" wire:model.defer="nota_fiscal"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="00000" required="" maxlength="5" x-mask="99999">
                    </div>

                    <div class="col-span-1">
                        <label for="valor" class="block mb-2 text-sm font-medium text-gray-900">Valor</label>
                        <input type="text" name="valor" id="valor" wire:model.defer="valor"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="R$ 0,00" required="" maxlength="14" x-mask:dynamic="$money($input, ',')">
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

                    @php
                        $isDisabled = empty($this->contrato_id);
                    @endphp

                    <button type="button" wire:click="save"
                        class="text-white inline-flex items-center bg-blue-500 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center
                        {{ $isDisabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $isDisabled ? 'disabled' : '' }}>
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
