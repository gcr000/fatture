<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Nuova Fattura') }}
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-top: -10px">
            {{ __("Compila i campi e invia la fattura via email al cliente.") }}
        </p>
    </header>

    <form method="post" action="{{ route('customers.send_invoice', $customer) }}" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <input type="hidden" name="customer_id" value="{{$customer->id}}">
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
            <div class="col-12">
                <div>
                    <x-input-label for="description" :value="__('Descrizione')" icon="bi bi-card-text" />
                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" required autocomplete="description" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center gap-4">
            <x-primary-button>{{ __('Salva la fattura') }}</x-primary-button>
        </div>
    </form>
</section>

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
    });
</script>
