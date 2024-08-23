<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stato invio Fatture') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="invoices_container"></div>
    </div>

    <script>
        let initial = true;

        $(function (){
            searchInAttesaInvoices();

            setInterval(() => {
                searchInAttesaInvoices();
            }, 3000);
        });

        function searchInAttesaInvoices(){

            let invoices_container = document.getElementById('invoices_container');
            setLoader();

            let url = "{{route('invoices.invoices_search_by_status', ['status' => 'in attesa'])}}";

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data){

                    let html = ``;

                    data.invoices.forEach(item => {
                        html += `
                            <div class="p-1 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                                <div class="max-w-7xl">
                                    <div class="flex justify-between">
                                        <div class="ms-4">
                                            <h5 class="title mt-2" style="">${item.customer.name} ${item.customer.surname}</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Fattura N. ${item.id} | Totale: ${item.amount} € <br> Data: ${moment(item.release_date).format('DD/MM/YYYY')}</p>
                                        </div>
                                        <div class="me-4">
                                           <p class="text-gray-500 mt-4 dark:text-gray-400">
                                                <span class="toLoader inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">${item.status}</span>
                                           </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    })

                    if(data.invoices.length == 0){
                        html = `

                        <div class="p-1 pt-2 bg-white shadow rounded-lg">
                            <h5 class="title" style="text-align: center!important;">Nessuna fattura in attesa di invio</h5>
                        </div>
                        `;
                    }

                    if(!initial)
                        setTimeout(() => {
                            invoices_container.innerHTML = html;
                        }, 2000);
                    else {
                        invoices_container.innerHTML = html;
                        initial = false;
                    }
                }
            });
        }

        function setLoader(){
            // recupero tutti gli span con la classe toLoader
            let toLoader = document.querySelectorAll('.toLoader');

            // per ogni span con la classe toLoader
            toLoader.forEach(item => {
                // metto un loader al posto del contenuto
                item.innerHTML = `
                <div class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                `;
            });
        }
    </script>
</x-app-layout>
