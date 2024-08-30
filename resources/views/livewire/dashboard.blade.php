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
            Finalizar Sessão (Logout)
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
                            {{ $contrato->contrato . ' - ' . $contrato->fornecedor }}
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

    @foreach ($this->listaContratos as $contrato)
        @php
            $valorTotalContrato = $contrato->pagamentos->sum('valor');
        @endphp
        <div class="flex flex-col items-center justify-center my-5">
            <div class="relative overflow-x-auto shadow-2xl border border-gray-400">
                <table class="w-full h-full text-sm font-light text-left text-gray-600">
                    <thead
                        class="text-xs tracking-wider text-gray-700 uppercase bg-gradient-to-b from-gray-50 to-gray-200 border-1 text-nowrap text-center h-12">
                        <tr>
                            <th scope="col" class="w-32 px-2 border">
                                Vencimento
                            </th>
                            <th scope="col" class="w-32 px-2 border">
                                Contrato
                            </th>
                            <th scope="col" class="w-32 px-2 border">
                                Parcela
                            </th>
                            <th scope="col" class="px-2 border">
                                Responsável / Informações Complementares
                            </th>
                            <th scope="col" class="w-32 px-6 border">
                                Nota Fiscal
                            </th>
                            <th scope="col" class="w-32 px-6 border">
                                Data Manutenção
                            </th>
                            <th scope="col" class="w-32 px-6 border">
                                Data do Pgto
                            </th>
                            <th scope="col" class="w-36 px-6 border">
                                Valor (R$)
                            </th>
                            <th scope="col" class="w-32 px-2 border">
                                Editar
                            </th>
                        </tr>
                    </thead>
                    <div
                        class="bg-white flex flex-col items-start justify-center h-16 uppercase text-sm font-medium tracking-wider border px-5 ">
                        <p>{{ $contrato->fornecedor }} - {{ $contrato->cnpj }}</p>
                        <p>{{ $contrato->objeto }}</p>
                    </div>
                    @foreach ($contrato->pagamentos as $pagamento)
                        <tbody>
                            <tr class="bg-white border-b">
                                <th scope="row"
                                    class="font-medium bg-gray-100 text-gray-900 whitespace-nowrap text-center border">
                                    {{ date('d/m/Y', strtotime($pagamento->vencimento)) }}
                                </th>
                                <td class="px-2 text-center border">
                                    {{ $contrato->contrato }}
                                </td>
                                <td class="text-center border">
                                    {{ $pagamento->parcela }}
                                </td>
                                <td class="px-2 text-center border">
                                    {{ substr($pagamento->responsavel, 0, 80) }}
                                </td>
                                <td class="text-center border">
                                    {{ $pagamento->nota_fiscal }}
                                </td>
                                <td class="px-2 text-center border">
                                    {{ $pagamento->data_manutencao ? $pagamento->data_manutencao->format('d/m/Y') : 'Sem Registro' }}
                                </td>
                                <td class="px-2 text-center border">
                                    {{ $pagamento->data_pagamento ? $pagamento->data_pagamento->format('d/m/Y') : 'Sem Registro' }}
                                </td>
                                <td class="flex flex-row items-center justify-between px-2 min-h-12">
                                    <div>(R$)</div>
                                    <div>{{ number_format($pagamento->valor, 2, ',', '.') }}</div>
                                </td>
                                <td class="bg-gray-100 border">
                                    <button wire:click="editPayment({{ $pagamento->id }})"
                                        x-on:click="editarPagamento = true"
                                        class="w-full h-full px-2 py-2 text-xs inline-flex items-center justify-center text-center hover:bg-gray-300 duration-500 uppercase">
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
                    <tfoot class="h-12">
                        <tr>
                            <td colspan="7"
                                class="bg-gradient-to-b from-gray-50 to-gray-200 text-end uppercase font-semibold tracking-widest px-2">
                                Valor Total:
                            </td>
                            <td class="flex items-center justify-between h-full px-3 font-medium border border-t-0">
                                <div>(R$)</div>
                                <div>{{ number_format($valorTotalContrato, 2, ',', '.') }}</div>
                            </td>
                            <td colspan="1" class="bg-gradient-to-b from-gray-50 to-gray-200"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endforeach

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
