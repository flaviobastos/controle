<div x-data="{ inserirFornecedor: false, inserirPagamento: false, editarPagamento: false, user: false, open: false }">

    <!-- Imagem de Loading -->
    <img wire:loading src="{{ asset('/images/loading.gif') }}" class="w-40 fixed inset-0 mx-auto my-auto z-50"
        alt="Loading">

    {{-- Menu Superior  --}}

    <section
        class="bg-slate-800 flex flex-row items-center justify-between p-2 overflow-x-auto fixed top-0 left-0 w-full z-50 text-nowrap print:hidden">

        <div>

            {{-- Botão de Usuário --}}

            <div class="flex flex-row items-center justify-between  w-full text-sm">
                <button @click="user = !user"
                    class="inline-flex items-center px-5 py-2 mx-2 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500 border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF"
                        viewBox="0 0 256 256" class="mr-2">
                        <path
                            d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z">
                        </path>
                    </svg>
                    <span class="hidden sm:inline-block"> {{ Auth::user()->name }}</span>
                </button>
            </div>

            <!-- Painel Informações do Usuário -->

            <div x-show="user" @click.outside="user = false" x-cloak
                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-80 p-4 bg-white border border-gray-300 rounded shadow-lg shadow-gray-500 font-light">

                <form class="flex flex-col items-center justify-center">

                    <p class="uppercase text-sm">{{ Auth::user()->name }}</p>
                    <p class="uppercase mb-4 text-sm">{{ Auth::user()->email }}</p>

                    <!-- Logout -->

                    <button wire:click="logout"
                        onclick="this.disabled = true; this.style.backgroundColor = '#515A5A'; this.style.cursor='wait'; setTimeout(() => this.disabled = false, 5000)"
                        class="w-full bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white py-2 px-5 mx-2 rounded-lg inline-flex items-center justify-center duration-500 border">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF"
                            viewBox="0 0 256 256" class="mr-2">
                            <path
                                d="M120,216a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H56V208h56A8,8,0,0,1,120,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L204.69,120H112a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,229.66,122.34Z">
                            </path>
                        </svg>
                        <span class="uppercase">Sair do Sistema</span>
                    </button>

                    <hr class="w-full h-0.5 mx-auto my-4 bg-gray-200 border-0 rounded">

                    <!-- Nova senha -->

                    <label for="new_password" class="block text-gray-700 font-medium mb-2">Nova Senha:</label>
                    <input wire:model.defer="new_password" type="password" id="new_password" name="new_password"
                        maxlength="8" placeholder="Digite uma senha"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2 text-center"
                        required>

                    <!-- Botão para alterar senha -->
                    <button wire:click="changePassword"
                        onclick="this.disabled = true; this.style.backgroundColor = '#515A5A'; this.style.cursor='wait'; setTimeout(() => this.disabled = false, 5000)"
                        class="w-full bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white py-2 px-5 mx-2 rounded-lg inline-flex items-center justify-center duration-500 border">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF"
                            viewBox="0 0 256 256" class="mr-2">
                            <path
                                d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                            </path>
                        </svg>
                        <span class="uppercase">Alterar Senha</span>
                    </button>

                    @error('new_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </form>

            </div>
        </div>

        <div class="flex flex-row items-center justify-center">

            {{-- Botão Inserir Contratos --}}

            <button x-on:click="inserirFornecedor = true"
                class="inline-flex items-center px-5 py-2 mx-2 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500 border">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                    viewBox="0 0 256 256" class="lg:mr-2">
                    <path
                        d="M216,72H131.31L104,44.69A15.86,15.86,0,0,0,92.69,40H40A16,16,0,0,0,24,56V200.62A15.4,15.4,0,0,0,39.38,216H216.89A15.13,15.13,0,0,0,232,200.89V88A16,16,0,0,0,216,72ZM92.69,56l16,16H40V56ZM216,200H40V88H216Zm-88-88a8,8,0,0,1,8,8v16h16a8,8,0,0,1,0,16H136v16a8,8,0,0,1-16,0V152H104a8,8,0,0,1,0-16h16V120A8,8,0,0,1,128,112Z">
                    </path>
                </svg>
                <span class="hidden sm:inline-block">Cadastrar Fornecedor</span>
            </button>

            {{-- Botão Inserir Pagamento --}}

            <button x-on:click="inserirPagamento = true"
                class="inline-flex items-center px-5 py-2 mx-2 rounded-3xl bg-slate-800 text-white hover:bg-slate-700 duration-500 border">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                    viewBox="0 0 256 256" class="lg:mr-2">
                    <path
                        d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z">
                    </path>
                </svg>
                <span class="hidden sm:inline-block">Inserir Pagamento</span>
            </button>

            {{-- Campo de Busca --}}

            <div class="bg-gray-50 border border-gray-400 rounded-3xl shadow-md">
                <div class="flex flex-row items-center justify-center py-1">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                        viewBox="0 0 256 256" class="ml-4">
                        <path
                            d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                        </path>
                    </svg>

                    <input wire:model.live.debounce.800ms="buscar" name="buscar"
                        class="appearance-none bg-transparent border-none flex-grow text-gray-700 pl-3 tracking-wider focus:outline-none sm:w-auto w-20 md:w-48"
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

    <section class="flex flex-col items-center justify-center w-full print:mt-0 mt-16 p-4">
        <div class="w-full">
            <table
                class="table-auto border-collapse min-w-full text-sm w-full font-light text-left text-gray-600 shadow-lg">
                <thead
                    class="text-xs tracking-wider text-gray-700 uppercase bg-gradient-to-b from-gray-50 to-gray-200 text-center h-14">
                    <tr>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Vencimento
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2 ">
                            Data do Pgto
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Contrato
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Fornecedor
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Cheque
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Nota Fiscal
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Parcela
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Responsável / Descrição (Obra ou Serviço)
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Data Manut.
                        </th>
                        <th scope="col" class="border border-gray-400 print:border-black px-2">
                            Valor (R$)
                        </th>
                        <th scope="col"
                            class="w-32 bg-gradient-to-b from-gray-50 to-gray-200 border border-gray-400 print:hidden">
                            <div class="flex flex-row items-center justify-center h-14">
                                <button @click="open = !open"
                                    class="{{ !empty($mes) || !empty($ano) || $filtro !== 'todos' ? 'border-2 border-dashed border-slate-800 animate-pulse' : '' }} w-full h-full px-2 py-2 text-sm inline-flex items-center justify-center text-center hover:bg-gray-300 duration-500 uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="#000000" viewBox="0 0 256 256" class="mr-2">
                                        <path
                                            d="M32,64a8,8,0,0,1,8-8H216a8,8,0,0,1,0,16H40A8,8,0,0,1,32,64Zm8,72h72a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16Zm88,48H40a8,8,0,0,0,0,16h88a8,8,0,0,0,0-16Zm109.66,13.66a8,8,0,0,1-11.32,0L206,177.36A40,40,0,1,1,217.36,166l20.3,20.3A8,8,0,0,1,237.66,197.66ZM184,168a24,24,0,1,0-24-24A24,24,0,0,0,184,168Z">
                                        </path>
                                    </svg>
                                    Filtrar
                                </button>
                            </div>
                        </th>
                    </tr>

                    <!-- Painel do Filtro do Dashboard -->

                    <div x-show="open" @click.outside="open = false" x-cloak
                        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-80 p-4 bg-white border border-gray-300 rounded shadow-lg shadow-gray-500 font-light">
                        <p class="uppercase mb-4 text-base">Filtrar Pagamentos:</p>

                        <form class="flex flex-col items-start justify-start">

                            {{-- Seletor de Contratos --}}

                            <div
                                class="flex flex-row w-full items-center justify-center py-2 mb-2 text-sm border border-gray-400">
                                <select wire:model="id_fornecedor" id="id_fornecedor" name="id_fornecedor"
                                    class="w-full text-center uppercase focus:outline-none px-2"
                                    wire:change="listPayments">
                                    <option value="" selected>Fornecedores (Todos)</option>
                                    @foreach ($seletorFornecedores as $fornecedor)
                                        <option value="{{ $fornecedor->id }}">
                                            {{ $fornecedor->fornecedor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro de Período -->

                            <div
                                class="flex flex-row w-full justify-between py-2 mb-4 gap-1 text-sm border border-gray-400">

                                <!-- Seletor de Mês -->
                                <select wire:model="mes" class="focus:outline-none px-2 w-40 text-center uppercase">
                                    <option value="">Mês</option>
                                    @php
                                        // Mapeamento dos números dos meses para os nomes em português
                                        $nomesMeses = [
                                            1 => 'Janeiro',
                                            2 => 'Fevereiro',
                                            3 => 'Março',
                                            4 => 'Abril',
                                            5 => 'Maio',
                                            6 => 'Junho',
                                            7 => 'Julho',
                                            8 => 'Agosto',
                                            9 => 'Setembro',
                                            10 => 'Outubro',
                                            11 => 'Novembro',
                                            12 => 'Dezembro',
                                        ];
                                    @endphp
                                    @foreach ($mesesDisponiveis as $mes)
                                        <option value="{{ $mes }}">
                                            {{ $nomesMeses[$mes] ?? 'Mês inválido' }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Seletor de Ano -->
                                <select wire:model="ano" class="focus:outline-none px-2">
                                    <option value="">Ano</option>
                                    @foreach ($anosDisponiveis as $ano)
                                        <option value="{{ $ano }}">{{ $ano }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <fieldset class="border w-full p-4 text-start">
                                <legend>Situação:</legend>
                                <div>
                                    <label class="flex items-center mb-4">
                                        <input wire:model="filtroContrato" type="checkbox" value="1"
                                            class="h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-gray-700">Apenas Pgtos C/
                                            Contrato</span>
                                    </label>
                                    <label class="flex items-center mb-2">
                                        <input wire:model="filtro" type="radio" value="todos"
                                            class="h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-gray-700">Todos</span>
                                    </label>
                                    <label class="flex items-center mb-2">
                                        <input wire:model="filtro" type="radio" value="pagos"
                                            class="h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-gray-700">Pagos</span>
                                    </label>
                                    <label class="flex items-center mb-2">
                                        <input wire:model="filtro" type="radio" value="abertos"
                                            class="h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-gray-700">Em aberto</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input wire:model="filtro" type="radio" value="vencimentos"
                                            class="h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-gray-700">Em Vencimento
                                            ({{ date('d/m/Y') }})</span>
                                    </label>
                                </div>
                            </fieldset>

                        </form>

                        <div class="flex flex-row w-full justify-between mt-4">
                            <button wire:click="clear"
                                class="border border-gray-400 py-2 px-4 hover:bg-gray-200">Limpar</button>
                            <button wire:click="applyFilter"
                                class="border border-gray-400 py-2 px-4 hover:bg-gray-200">Aplicar</button>
                        </div>

                    </div>

                </thead>
                @foreach ($this->listaPagamentos as $pagamento)
                    <tbody>
                        <tr class="bg-white border h-14">
                            <th scope="row" class="font-normal bg-gray-100 text-gray-900 text-center border">
                                <div class="flex flex-row items-center justify-center px-2">
                                    {{ date('d/m/Y', strtotime($pagamento->vencimento)) }}
                                    @if ($pagamento->data_pagamento)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#17b052" viewBox="0 0 256 256" class="ml-2">
                                            <path
                                                d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z">
                                            </path>
                                        </svg>
                                    @elseif (strtotime($pagamento->vencimento) <= strtotime(now()))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#ee2020" viewBox="0 0 256 256" class="ml-2">
                                            <path
                                                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#000000" viewBox="0 0 256 256" class="ml-2">
                                            <path
                                                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <td class="text-center h-14">
                                @if ($pagamento->data_pagamento)
                                    <div class="bg-green-200 flex flex-row items-center justify-center w-full h-full">
                                        {{ date('d/m/Y', strtotime($pagamento->data_pagamento)) }}
                                    </div>
                                @else
                                    @php
                                        $status =
                                            strtotime($pagamento->vencimento) <= strtotime(now())
                                                ? 'Em Vencimento'
                                                : 'Em Aberto';
                                    @endphp
                                    <div
                                        class="flex flex-row items-center justify-center w-full h-full px-2 {{ strtotime($pagamento->vencimento) <= strtotime(now()) ? 'bg-red-200' : '' }}">
                                        {{ $status }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 text-center border">
                                {{ $pagamento->contrato ?? 'Sem Contrato' }}
                            </td>
                            <td class="px-2 text-center border uppercase max-w-40">
                                <div class="truncate ">{{ $pagamento->fornecedor->fornecedor }}</div>
                            </td>
                            <td class="px-2 text-center border">
                                {{ $pagamento->cheque ?? '-' }}
                            </td>
                            <td class="px-2 text-center border">
                                {{ $pagamento->nota_fiscal ?? '-' }}
                            </td>
                            <td class="px-2 text-center border">
                                {{ $pagamento->parcela }}
                            </td>
                            <td class="max-w-52 relative text-center border uppercase cursor-pointer group">
                                <div class="truncate px-2">{{ $pagamento->responsavel }}</div>
                                <div
                                    class="hidden group-hover:flex absolute top-1/4 left-1/4 transform -translate-x-1/2 -translate-y-full z-40 bg-gray-700 text-white text-sm rounded py-1 px-2 w-fit h-auto text-wrap text-center">
                                    {{ $pagamento->responsavel }}
                                </div>
                            </td>
                            <td class="border">
                                <div class="flex flex-row items-center justify-center w-full h-full">
                                    @if ($pagamento->data_manutencao)
                                        <div
                                            class="flex flex-row items-center justify-center w-full h-full 
                                                {{ strtotime($pagamento->data_manutencao) <= strtotime(now()) && !$pagamento->status_manutencao ? 'bg-red-200' : ($pagamento->status_manutencao ? 'bg-green-200' : '') }}">
                                            {{ date('d/m/Y', strtotime($pagamento->data_manutencao)) }}
                                        </div>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-row items-center justify-between px-2">
                                    <span>(R$)</span>
                                    <span>{{ number_format($pagamento->valor, 2, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="bg-gray-100 border h-14 border-gray-400 print:hidden">
                                <button wire:click="editPayment({{ $pagamento->id }})"
                                    x-on:click="editarPagamento = true"
                                    class="w-full h-full px-2 py-2 text-sm inline-flex items-center justify-center text-center hover:bg-gray-300 duration-500 uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5 mr-2">
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
            </table>
        </div>

        @if ($this->listaPagamentos->isEmpty())
            <p class="text-center w-full bg-gray-600 text-white py-2">Nenhum resultado
                encontrado.</p>
        @endif

    </section>

    <div x-show="inserirFornecedor" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div
                class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90 overflow-y-auto">
                @livewire('inserir-fornecedor')
            </div>
        </div>
    </div>

    <div x-show="inserirPagamento" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div
                class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90 overflow-y-auto">
                @livewire('inserir-pagamento')
            </div>
        </div>
    </div>

    <div x-show="editarPagamento" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div
                class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90 overflow-y-auto">
                @livewire('editar-pagamento')
            </div>
        </div>
    </div>

</div>
