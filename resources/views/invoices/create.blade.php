<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuova Fattura') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    <h5 class="title mt-2 mb-4" style="">Dati Fattura</h5>

                    <form method="post" action="{{ route('invoices.massive_send_email') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="col-4">
                                <div>
                                    <x-input-label for="amount" :value="__('Importo')" icon="bi bi-currency-euro" />
                                    <x-text-input id="amount" value="0" name="amount" type="number" step="0.01" class="mt-1 block w-full" required autocomplete="amount" />
                                    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <x-input-label for="amount_letter" :value="__('Importo in lettere')" icon="bi bi-currency-euro" />
                                    <x-text-input id="amount_letter" name="amount_letter" type="text" class="mt-1 block w-full" required autocomplete="amount_letter"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('amount_letter')" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <x-input-label for="release_date" :value="__('Data')" icon="bi bi-calendar" />
                                    <x-text-input id="release_date" name="release_date" type="text" class="mt-1 block w-full" required autocomplete="release_date" />
                                    <x-input-error class="mt-2" :messages="$errors->get('release_date')" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div>
                                    <x-input-label for="description" :value="__('Descrizione')" icon="bi bi-card-text" />
                                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" required autocomplete="description" />
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">

                </div>
            </div>

            {{--<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl w-full text-center">
                    <x-primary-button center="true" class="w-full text-center" onclick="sendFattura()"><i class="bi bi-envelope-at me-2"></i> {{ __('Invia Fattura via email') }}</x-primary-button>
                </div>
            </div>--}}
        </div>
    </div>

    <script>
        $(function(){
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
        });
    </script>
    {{--<script>
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
    </script>--}}
</x-app-layout>
