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
                        <label for="fornecedor_id" class="block mb-2 text-sm font-medium text-gray-900">Selecionar
                            Fornecedor</label>
                        <select id="fornecedor_id" wire:model.live="fornecedor_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 uppercase">
                            <option value="" selected="">Selecione o Fornecedor</option>
                            @foreach ($listaFornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}">
                                    {{ $fornecedor->fornecedor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900">Tipo do
                            Pagamento</label>
                        <select id="tipo" wire:model.live="tipoPagamento"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 text-center">
                            <option value="">Sem Contrato</option>
                            <option value="1">Com Contrato</option>
                        </select>
                    </div>

                    @php
                        $isContract = empty($this->tipoPagamento);
                    @endphp

                    <div class="col-span-1">
                        <label for="contrato" class="block mb-2 text-sm font-medium text-gray-900">Número do
                            Contrato</label>
                        <input type="text" name="contrato" id="contrato" wire:model.defer="contrato"
                            {{ $isContract ? 'disabled' : '' }}
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 {{ $isContract ? 'opacity-50 cursor-not-allowed' : '' }} "
                            placeholder="XXXXXX/202X" required="" maxlength="15" x-data
                            x-on:input="$event.target.value = $event.target.value.replace(/[^0-9\/]/g, '').replace(/(\/.*)\/+/, '$1')">
                    </div>

                    <div class="col-span-2">
                        <label for="responsavel" class="block mb-2 text-sm font-medium text-gray-900">Responsável /
                            Descrição</label>
                        <textarea name="responsavel" id="responsavel" wire:model.defer="responsavel" rows="4" style="resize:none"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase"
                            placeholder="Responsável e descrição do serviço ou material" required="" maxlength="255"></textarea>
                    </div>

                    <div class="col-span-1">
                        <label for="vencimento" class="block mb-2 text-sm font-medium text-gray-900">Vencimento</label>
                        <input type="date" name="vencimento" id="vencimento" wire:model.defer="vencimento"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required="">
                    </div>

                    <div class="col-span-1">
                        <label for="parcelas" class="block mb-2 text-sm font-medium text-gray-900">Qtd.
                            Parcela(s)</label>
                        <input type="number" name="parcelas" id="parcelas" wire:model.live.debounce.1000ms="parcela"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="" min="1" max="5" required="">
                    </div>

                    @foreach ($valor as $index => $valorItem)
                        <div class="col-span-1">
                            <label for="nota_fiscal.{{ $index }}"
                                class="block mb-2 text-sm font-medium text-gray-900">
                                Nota Fiscal ({{ $index + 1 }}ª Parcela)
                            </label>
                            <input type="text" name="nota_fiscal.{{ $index }}"
                                id="nota_fiscal.{{ $index }}" wire:model.defer="nota_fiscal.{{ $index }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="00000" required="" maxlength="5" x-mask="99999">
                        </div>

                        <div class="col-span-1">
                            <label for="valor.{{ $index }}"
                                class="block mb-2 text-sm font-medium text-gray-900">
                                Valor ({{ $index + 1 }}ª Parcela)
                            </label>
                            <input type="text" name="valor.{{ $index }}" id="valor.{{ $index }}"
                                wire:model.defer="valor.{{ $index }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="R$ 0,00" required="" maxlength="14"
                                x-mask:dynamic="$money($input, ',')">
                        </div>
                    @endforeach
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
                        $isDisabled = empty($this->fornecedor_id);
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
