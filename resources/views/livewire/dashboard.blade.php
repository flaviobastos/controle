<div x-data="{ inserirContrato: false }">
    <div class="bg-slate-700 flex flex-row items-center justify-end p-2">

        <div>
            <button x-on:click="inserirContrato = true"
                class="inline-flex items-center px-5 py-2 rounded-3xl bg-slate-700 text-white hover:bg-slate-800 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" viewBox="0 0 256 256"
                    class="mr-2">
                    <path
                        d="M216,72H131.31L104,44.69A15.86,15.86,0,0,0,92.69,40H40A16,16,0,0,0,24,56V200.62A15.4,15.4,0,0,0,39.38,216H216.89A15.13,15.13,0,0,0,232,200.89V88A16,16,0,0,0,216,72ZM92.69,56l16,16H40V56ZM216,200H40V88H216Zm-88-88a8,8,0,0,1,8,8v16h16a8,8,0,0,1,0,16H136v16a8,8,0,0,1-16,0V152H104a8,8,0,0,1,0-16h16V120A8,8,0,0,1,128,112Z">
                    </path>
                </svg>
                Cadastrar Contrato
            </button>
        </div>

        <div>
            <button wire:click="logout"
                class="inline-flex items-center px-5 py-2 rounded-3xl bg-slate-700 text-white hover:bg-slate-800 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                    viewBox="0 0 256 256" class="mr-2">
                    <path
                        d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z">
                    </path>
                </svg>
                Inserir Pagamento
            </button>
        </div>

        <div>
            <button wire:click="logout"
                onclick="this.disabled = true; this.style.backgroundColor = '#515A5A'; this.style.cursor='wait'; setTimeout(() => this.disabled = false, 5000)"
                class="inline-flex items-center px-5 py-2 rounded-3xl bg-slate-700 text-white hover:bg-slate-800 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF"
                    viewBox="0 0 256 256" class="mr-2">
                    <path
                        d="M120,216a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H56V208h56A8,8,0,0,1,120,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L204.69,120H112a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,229.66,122.34Z">
                    </path>
                </svg>
                Logout
            </button>
        </div>
    </div>

    <div x-show="inserirContrato" x-cloak>
        <div class="fixed z-50 inset-0 overflow-x-hidden overflow-y-hidden">
            <div class="flex flex-col items-center justify-center h-screen w-full bg-slate-700 bg-opacity-90">
                @livewire('inserir-contrato')
            </div>
        </div>
    </div>

</div>
