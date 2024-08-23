<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Fatture') }}
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-top: -10px">
            {{ __("Elenco delle fatture associate al cliente.") }}
        </p>
    </header>

    <div class="mt-4">
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">{{ __('Numero') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('Data') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('Importo') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('Stato') }}</th>
                        <th class="px-4 py-2 text-left">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customer->invoices as $invoice)
                        <tr>
                            <td class="border px-4 py-2">{{ $invoice->customer_invoice_number }}</td>
                            <td class="border px-4 py-2">{{ date('d/m/Y', strtotime($invoice->release_date)) }}</td>
                            <td class="border px-4 py-2">{{ number_format($invoice->amount,2,',', '.') }} €</td>
                            <td class="border px-4 py-2">{{ $invoice->status }}</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600">
                                    {{ __('Visualizza') }}
                                </a>
                                @if($invoice->status != 'pagata')
                                    |
                                    <span onclick="deleteInvoice('{{$invoice->id}}','{{ $invoice->customer_invoice_number }}','{{ number_format($invoice->amount,2,',', '.') }}')" style="cursor: pointer" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">
                                        {{ __('Elimina') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if($customer->invoices->count() == 0)
                        <tr>
                            <td class="border px-4 py-2 text-center" colspan="5">
                                <i>{{ __('Nessuna fattura') }}</i>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
</section>

<script>
    function deleteCustomer() {
        if (confirm('Sei sicuro di voler cancellare questo cliente e tutte le sue fatture?')) {

            let url = '{{url("customer_destroy/".$customer->id)}}';
            $.ajax({
                url: url,
                success: function(response) {
                    window.location.href = '{{ route('dashboard') }}';
                }
            });
        }
    }

    function deleteInvoice(id, number, amount) {
        if (confirm('Sei sicuro di voler cancellare la fattura n. ' + number + ' da ' + amount + ' €?')) {

            let url = '{{url("invoice_destroy")}}' + '/' + id;
            $.ajax({
                url: url,
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    }
</script>
