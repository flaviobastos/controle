<div x-data="{ inserirContrato: false, inserirPagamento: false }">

    {{-- MENU / BARRA DE PESQUISA  --}}

    <section class="bg-slate-800 flex flex-row items-center justify-between p-2">

        <button wire:click="logout"
            onclick="this.disabled = true; this.style.backgroundColor = '#515A5A'; this.style.cursor='wait'; setTimeout(() => this.disabled = false, 5000)"
            class="inline-flex items-center px-5 py-2 mx-2 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF" viewBox="0 0 256 256"
                class="mr-2">
                <path
                    d="M120,216a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H56V208h56A8,8,0,0,1,120,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L204.69,120H112a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,229.66,122.34Z">
                </path>
            </svg>
            Logout
        </button>

        <div class="flex flex-row items-center justify-center">

            <button x-on:click="inserirContrato = true"
                class="inline-flex items-center px-5 py-2 mx-2 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                    viewBox="0 0 256 256" class="mr-2">
                    <path
                        d="M216,72H131.31L104,44.69A15.86,15.86,0,0,0,92.69,40H40A16,16,0,0,0,24,56V200.62A15.4,15.4,0,0,0,39.38,216H216.89A15.13,15.13,0,0,0,232,200.89V88A16,16,0,0,0,216,72ZM92.69,56l16,16H40V56ZM216,200H40V88H216Zm-88-88a8,8,0,0,1,8,8v16h16a8,8,0,0,1,0,16H136v16a8,8,0,0,1-16,0V152H104a8,8,0,0,1,0-16h16V120A8,8,0,0,1,128,112Z">
                    </path>
                </svg>
                Cadastrar Contrato
            </button>

            <button x-on:click="inserirPagamento = true"
                class="inline-flex items-center px-5 py-2 mx-2 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                    viewBox="0 0 256 256" class="mr-2">
                    <path
                        d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z">
                    </path>
                </svg>
                Inserir Pagamento
            </button>


            <div class="bg-gray-50 border border-gray-400 rounded-3xl shadow-md text-nowrap">
                <div class="flex flex-row items-center justify-center py-1">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                        viewBox="0 0 256 256" class="ml-4">
                        <path
                            d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                        </path>
                    </svg>

                    <input wire:model.live.debounce.800ms="buscar" name="buscar"
                        class="appearance-none bg-transparent border-none w-80 text-gray-700 pl-3 tracking-wider focus:outline-none"
                        maxlength="30" type="text" placeholder="Buscar" aria-label="Campo de pesquisa">

                    <button wire:click="clear"
                        class="inline-flex items-center justify-center px-5 py-2 mx-1 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                            viewBox="0 0 256 256" class="mr-2">
                            <path
                                d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z">
                            </path>
                        </svg>
                        LIMPAR
                    </button>

                </div>
            </div>

        </div>

    </section>

    @if ($this->listaContratos->isNotEmpty())
        <div class="flex flex-col items-center justify-center">
            <div class="relative overflow-x-auto shadow-md">
                <table class="w-screen h-full text-sm font-light text-left text-gray-600">
                    <thead
                        class="text-xs tracking-wider text-gray-700 uppercase bg-gray-200 border-1 text-nowrap text-center">
                        <tr>
                            <th scope="col" class="px-6 py-6">
                                Vencimento
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Contrato
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Fornecedor
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Objeto do Contrato
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Parcela
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Responsável
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Nota Fiscal
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Valor (R$)
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Data do Pgto
                            </th>
                            <th scope="col" class="px-6 py-6">
                                Data Manutenção
                            </th>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center justify-center">
                                    Editar
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $lastContractId = null;
                        @endphp
                        @foreach ($this->listaContratos as $contrato)
                            @if ($lastContractId !== null && $lastContractId !== $contrato->id)
                                <!-- Linha separadora entre contratos -->
                                <tr>
                                    <td colspan="11" class="py-0.5 bg-gray-300"></td>
                                </tr>
                            @endif
                            @foreach ($contrato->pagamentos as $pagamento)
                                <tr class="bg-white border-b">
                                    <th scope="row"
                                        class="py-8 font-medium bg-gray-100  text-gray-900 whitespace-nowrap text-center">
                                        {{ date('d/m/Y', strtotime($pagamento->vencimento)) }}
                                    </th>
                                    <td class="px-2 py-8 text-center">
                                        {{ $contrato->contrato }}
                                    </td>
                                    <td class="px-2 py-8 text-start">
                                        {{ $contrato->fornecedor }}
                                    </td>
                                    <td class="px-2 py-8 text-start">
                                        {{ substr($contrato->objeto, 0, 40) }} <span
                                            class="lowercase text-xs cursor-pointer font-medium underline">(visualizar)</span>
                                    </td>
                                    <td class="py-8 text-center">
                                        {{ $pagamento->parcela }}
                                    </td>
                                    <td class="px-2 py-8">
                                        {{ $pagamento->responsavel }}
                                    </td>
                                    <td class="py-8 text-center">
                                        {{ $pagamento->nota_fiscal }}
                                    </td>
                                    <td class="px-2 py-8">
                                        R$ {{ number_format($pagamento->valor, 2, ',', '.') }}
                                    </td>
                                    <td class="px-2 py-8">
                                        @if (!is_null($pagamento->data_pagamento))
                                            {{ date('d/m/Y', strtotime($pagamento->data_pagamento)) }}
                                        @endif
                                    </td>
                                    <td class="px-2 py-8">
                                        @if (!is_null($pagamento->data_pagamento))
                                            {{ date('d/m/Y', strtotime($pagamento->data_manutencao)) }}
                                        @endif
                                    </td>
                                    <td class="bg-gray-100">
                                        <button wire:click=""
                                            class="w-full h-full px-2 py-2 inline-flex items-center text-center hover:bg-gray-300 duration-500 uppercase">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="#000000" viewBox="0 0 256 256" class="mr-2">
                                                <path
                                                    d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z">
                                                </path>
                                            </svg>
                                            Editar Pgto
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @php
                                $lastContractId = $contrato->id;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div x-show="inserirContrato" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90">
                @livewire('inserir-contrato')
            </div>
        </div>
    </div>

    <div x-show="inserirPagamento" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90">
                @livewire('inserir-pagamento')
            </div>
        </div>
    </div>

</div>
