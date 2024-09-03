<div x-data="{ inserirContrato: false, inserirPagamento: false, editarPagamento: false }">

    <!-- Imagem de Loading -->
    <img wire:loading src="{{ asset('/images/loading.gif') }}" class="w-40 fixed inset-0 mx-auto my-auto z-50"
        alt="Loading">

    {{-- Menu / Barra de Pesquisa  --}}

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

            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                    viewBox="0 0 256 256" class="mr-2">
                    <path
                        d="M80,64a8,8,0,0,1,8-8H216a8,8,0,0,1,0,16H88A8,8,0,0,1,80,64Zm136,56H88a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Zm0,64H88a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16ZM44,52A12,12,0,1,0,56,64,12,12,0,0,0,44,52Zm0,64a12,12,0,1,0,12,12A12,12,0,0,0,44,116Zm0,64a12,12,0,1,0,12,12A12,12,0,0,0,44,180Z">
                    </path>
                </svg>
                <select wire:model.live="id_contrato" id="id_contrato" name="id_contrato"
                    class="bg-slate-800 text-white text-md text-start py-3 px-2 mr-3 tracking-wider focus:outline-none"
                    wire:change="listContracts">
                    <option value="" selected>Exibir Todos os Contratos</option>
                    @foreach ($seletorContratos as $contrato)
                        <option value="{{ $contrato->id }}">
                            {{ $contrato->contrato . ' - ' . substr($contrato->fornecedor, 0, 10) }}...
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="bg-gray-50 border border-gray-400 rounded-3xl shadow-md text-nowrap">
                <div class="flex flex-row items-center justify-center py-1">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                        viewBox="0 0 256 256" class="ml-4">
                        <path
                            d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                        </path>
                    </svg>

                    <input wire:model.live.debounce.800ms="buscar" name="buscar"
                        class="appearance-none bg-transparent border-none w-48 text-gray-700 pl-3 tracking-wider focus:outline-none"
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

    <section>

        @foreach ($this->listaContratos as $contrato)
            @php
                $valorTotalContrato = $contrato->pagamentos->sum('valor');
                $dataMaisRecente = $contrato->pagamentos->max('data_manutencao');
                $pagamentoMaisRecente = $contrato->pagamentos->max('data_pagamento');
                $qtdParcelas = $contrato->pagamentos->count('parcela');
            @endphp
            <div class="my-7 px-5">
                <div
                    class="flex flex-col items-start justify-center p-5 h-20 uppercase text-sm font-medium tracking-wider bg-gray-50 border border-b-0 border-gray-400">
                    <p>Fornecedor: {{ $contrato->fornecedor }} - {{ $contrato->cnpj }}</p>
                    <p>Objeto do Contrato: {{ $contrato->objeto }}</p>
                </div>
                <div class="shadow-xl border border-gray-400 overflow-x-auto text-nowrap">
                    <table
                        class="w-full h-full text-sm font-light text-left text-gray-600 border-separate border-spacing-1">
                        <thead
                            class="text-xs tracking-wider text-gray-700 uppercase bg-gradient-to-b from-gray-50 to-gray-200 border-1 text-center h-14">
                            <tr>
                                <th scope="col" class="w-32 px-2 border border-gray-400">
                                    Vencimento
                                </th>
                                <th scope="col" class="w-32 px-2 border border-gray-400">
                                    Contrato
                                </th>
                                <th scope="col" class="w-96 px-2 border border-gray-400">
                                    Responsável / Informações Complementares
                                </th>
                                <th scope="col" class="w-32 px-2 border border-gray-400">
                                    Parcela
                                </th>
                                <th scope="col" class="w-32 px-6 border border-gray-400">
                                    Nota Fiscal
                                </th>
                                <th scope="col" class="w-32 px-6 border border-gray-400">
                                    Data do Pgto
                                </th>
                                <th scope="col" class="w-32 px-6 border border-gray-400">
                                    Data Manut.
                                </th>
                                <th scope="col" class="w-32 px-6 border border-gray-400">
                                    Valor (R$)
                                </th>
                                <th scope="col" class="w-32 px-2 border border-gray-400">
                                    Editar
                                </th>
                            </tr>
                        </thead>
                        @foreach ($contrato->pagamentos as $pagamento)
                            <tbody>
                                <tr class="bg-white border">
                                    <th scope="row" class="font-medium bg-gray-100 text-gray-900 text-center border">
                                        <div class="flex flex-row items-center justify-center">
                                            {{ date('d/m/Y', strtotime($pagamento->vencimento)) }}
                                            @if ($pagamento->data_pagamento)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="#17b052" viewBox="0 0 256 256" class="ml-2">
                                                    <path
                                                        d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z">
                                                    </path>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="#ee2020" viewBox="0 0 256 256" class="ml-2">
                                                    <path
                                                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>
                                    </th>
                                    <td class="px-2 text-center border">
                                        {{ $contrato->contrato }}
                                    </td>
                                    <td class="px-2 text-center border uppercase">
                                        {{ $pagamento->responsavel }}
                                    </td>
                                    <td class="text-center border">
                                        0{{ $pagamento->parcela }}
                                    </td>
                                    <td class="text-center border">
                                        {{ $pagamento->nota_fiscal }}
                                    </td>
                                    <td class="px-2 text-center border">
                                        <div class="flex flex-row items-center justify-center">
                                            @if ($pagamento->data_pagamento)
                                                <strong>{{ date('d/m/Y', strtotime($pagamento->data_pagamento)) }}</strong>
                                            @else
                                                Sem Registro
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 text-center border">
                                        <div class="flex flex-row items-center justify-center">
                                            @if ($pagamento->data_manutencao)
                                                <strong>{{ date('d/m/Y', strtotime($pagamento->data_manutencao)) }}</strong>
                                            @else
                                                Sem Registro
                                            @endif
                                        </div>
                                    </td>
                                    <td class="flex flex-row items-center justify-between px-2 h-14 border">
                                        <div>(R$)</div>
                                        <div>{{ number_format($pagamento->valor, 2, ',', '.') }}</div>
                                    </td>
                                    <td class="bg-gray-100 border border-gray-400">
                                        <button wire:click="editPayment({{ $pagamento->id }})"
                                            x-on:click="editarPagamento = true"
                                            class="w-full h-full px-2 py-2 text-sm inline-flex items-center justify-center text-center hover:bg-gray-300 duration-500 uppercase">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-5 mr-2">
                                                <path
                                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                <path
                                                    d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                            </svg>
                                            Editar Pgto
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                        <tfoot class="h-14 border">
                            <tr>
                                <td
                                    class="bg-gradient-to-b from-gray-50 to-gray-200 text-center uppercase font-semibold tracking-widest px-2 border border-gray-400">
                                    02 em Aberto
                                </td>
                                <td colspan="2"
                                    class="bg-gradient-to-b from-gray-50 to-gray-200 border border-gray-400 text-center font-semibold">
                                    Informações Contratuais
                                </td>
                                <td colspan="2"
                                    class="bg-gradient-to-b from-gray-50 to-gray-200 border border-gray-400 text-center font-semibold">
                                    (0{{ $qtdParcelas }}) Parcelas / N.F
                                </td>
                                <td colspan="1"
                                    class="bg-gradient-to-b from-gray-50 to-gray-200 border border-gray-400 text-center font-semibold">
                                    {{ date('d/m/Y', strtotime($pagamentoMaisRecente)) }}
                                </td>
                                <td colspan="1"
                                    class="bg-gradient-to-b from-gray-50 to-gray-200 border border-gray-400 text-center font-semibold">
                                    {{ date('d/m/Y', strtotime($dataMaisRecente)) }}
                                </td>
                                <td colspan="1"
                                    class="bg-gradient-to-b from-gray-50 to-gray-200 flex items-center justify-between h-full px-3 font-medium border border-gray-400">
                                    <div>(R$)</div>
                                    <div>{{ number_format($valorTotalContrato, 2, ',', '.') }}</div>
                                </td>
                                <td class="bg-gray-100 border border-gray-400">
                                    <button wire:click=""
                                        class="w-full h-full px-2 py-2 text-sm inline-flex items-center justify-center text-center hover:bg-gray-300 duration-500 uppercase">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#000000" viewBox="0 0 256 256" class="mr-2">
                                            <path
                                                d="M32,64a8,8,0,0,1,8-8H216a8,8,0,0,1,0,16H40A8,8,0,0,1,32,64Zm8,72h72a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16Zm88,48H40a8,8,0,0,0,0,16h88a8,8,0,0,0,0-16Zm109.66,13.66a8,8,0,0,1-11.32,0L206,177.36A40,40,0,1,1,217.36,166l20.3,20.3A8,8,0,0,1,237.66,197.66ZM184,168a24,24,0,1,0-24-24A24,24,0,0,0,184,168Z">
                                            </path>
                                        </svg>
                                        Filtro Pgto
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endforeach

    </section>

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

    <div x-show="editarPagamento" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90">
                @livewire('editar-pagamento')
            </div>
        </div>
    </div>

</div>
