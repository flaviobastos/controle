<div class="relative p-4 w-full max-w-md max-h-full">
    <!-- Imagem de Loading -->
    <img wire:loading src="{{ asset('/images/loading.gif') }}" class="w-40 fixed inset-0 mx-auto my-auto z-50"
        alt="Loading">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <p class="text-lg font-semibold text-gray-900">
                Editar Pagamento
            </p>
            <button type="button" wire:click="closeWindow" x-on:click="editarPagamento=false" id="closeEditButton"
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
                    <label for="responsavel" class="block mb-2 text-sm font-medium text-gray-900">Responsável</label>
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
                    <label for="parcela" class="block mb-2 text-sm font-medium text-gray-900">Parcela</label>
                    <input type="text" name="parcela" id="parcela" wire:model.defer="parcela"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="00" required="" maxlength="5" x-mask="99">
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

                <div class="col-span-1">
                    <label for="data_pagamento" class="block mb-2 text-sm font-medium text-gray-900">Data
                        Pagamento</label>
                    <input type="date" name="data_pagamento" id="data_pagamento" wire:model.defer="data_pagamento"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        required="">
                </div>

                <div class="col-span-1">
                    <label for="data_manutencao" class="block mb-2 text-sm font-medium text-gray-900">Data
                        Manutenção</label>
                    <input type="date" name="data_manutencao" id="data_manutencao" wire:model.defer="data_manutencao"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        required="">
                    <label class="flex items-center justify-start">
                        <span class="mr-4 text-gray-700 text-sm font-normal uppercase my-3">Manut. Concluída</span>
                        <input wire:model.live="status_manutencao" type="checkbox" class="h-5 w-5 text-blue-600">
                    </label>
                </div>

            </div>

            <div class="flex flex-row items-center justify-between">

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

                <button type="button" wire:click="update"
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
                    document.getElementById('closeEditButton').click();
                }
            });
        });
    }

    // Configurações específicas para cada evento

    handleContractAction(
        'deletePaymentMsg',
        'Tem certeza disso?',
        'warning',
        'Sim, excluir',
        'Não, cancelar',
        'O pagamento no valor de <strong>R$ {contractNumber}</strong> será excluído permanentemente.',
        'paymentDelete'
    );

    handleContractAction(
        'editPaymentMsg',
        'Tem certeza disso?',
        'question',
        'Sim, atualizar',
        'Não, cancelar',
        'Os dados existentes serão serão substituídos permanentemente.',
        'paymentEdit'
    );
</script>
