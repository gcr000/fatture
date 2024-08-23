<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dettaglio Fattura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    @include('invoices.partials.detail-customer')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    @include('invoices.partials.detail-invoice')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    @include('invoices.partials.invoice-histories')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3" style="background-color: var(--custom-color1)!important;">
                <div class="max-w-7xl">
                    <h5 class="title mt-2 mb-4" style="">Anteprima Fattura</h5>
                    <iframe width="100%" height="650px" src="{{route('invoices.preview_pdf', $invoice)}}" frameborder="1"></iframe>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl w-full text-center">
                    <x-primary-button center="true" class="w-full text-center" onclick="sendFattura()"><i class="bi bi-envelope-at me-2 nuovo_elemento_icon"></i> {{ __('Invia Fattura via email') }}</x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function (){
            let release_date = document.getElementById('release_date');

            $(release_date).daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                locale: {
                    format: 'DD/MM/YYYY',
                    separator: ' - ',
                    applyLabel: 'Applica',
                    cancelLabel: 'Annulla',
                    fromLabel: 'Da',
                    toLabel: 'A',
                    customRangeLabel: 'Custom',
                    weekLabel: 'W',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
                    monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    firstDay: 1
                }
            });

            // recupera da php la variabile $invoice->release_date e settala come valore di default
            let release_date_value = '{{date('d/m/Y', strtotime($invoice->release_date))}}';
            $(release_date).val(release_date_value);

            // seleziona sul calendario la data di default
            $(release_date).data('daterangepicker').setStartDate(release_date_value);
            // rimuovi dal calendario la data di oggi selezionata di default
            $(release_date).data('daterangepicker').setEndDate(release_date_value);

        });

        function updateStatus(select){
            let status = select.value;
            let invoice_id = '{{$invoice->id}}';
            $.ajax({
                url: '{{route('invoices.update_status')}}',
                type: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    status: status,
                    invoice_id: invoice_id
                },
                success: function(response){
                    window.location.reload();
                }
            });
        }

        function sendFattura(){
            Swal.fire({
                icon: "success",
                title: "Invio email in corso",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                allowOutsideClick: false
            });

            $.ajax({
                url: '{{route('invoices.send_email')}}',
                type: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    invoiceId: '{{$invoice->id}}'
                },
                success: function(response){
                    if(response.status === 'success'){
                        Swal.fire({
                            icon: "success",
                            title: "Email inviata con successo",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            allowOutsideClick: false
                        });
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "Errore nell'invio dell'email",
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            allowOutsideClick: false
                        });
                    }
                },
                error: function(){
                    Swal.fire({
                        icon: "error",
                        title: "Errore nell'invio dell'email",
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        allowOutsideClick: false
                    });
                }
            });

        }
    </script>
</x-app-layout>
