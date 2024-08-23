<form method="post" action="{{ route('invoices.update', $invoice) }}" class="mt-6 space-y-6">
    @csrf
    @method('POST')

    <h5 class="title mt-4" style="margin-bottom: -15px">Dati Fattura</h5>
    <div class="row">
        <div class="col-4">
            <div>
                @if($invoice->status == 'pagata')
                    <x-input-label for="amount" :value="__('Importo')" icon="bi bi-currency-euro" />
                    <x-text-input id="amount" value="0" name="amount" type="number" step="0.01" class=" input_disabled mt-1 block w-full" required autocomplete="amount" value="{{$invoice->amount}}" disabled />
                @else
                    <x-input-label for="amount" :value="__('Importo')" icon="bi bi-currency-euro" />
                    <x-text-input id="amount" value="0" name="amount" type="number" step="0.01" class="mt-1 block w-full" required autocomplete="amount" value="{{$invoice->amount}}" />
                    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                @endif
            </div>
        </div>
        <div class="col-4">
            <div>
                @if($invoice->status == 'pagata')
                    <x-input-label for="amount_letter" :value="__('Importo in lettere')" icon="bi bi-currency-euro" />
                    <x-text-input id="amount_letter" name="amount_letter" type="text" class=" input_disabled mt-1 block w-full" required autocomplete="amount_letter" value="{{$invoice->amount_letter}}" disabled />
                @else
                    <x-input-label for="amount_letter" :value="__('Importo in lettere')" icon="bi bi-currency-euro" />
                    <x-text-input id="amount_letter" name="amount_letter" type="text" class="mt-1 block w-full" required autocomplete="amount_letter" value="{{$invoice->amount_letter}}" />
                    <x-input-error class="mt-2" :messages="$errors->get('amount_letter')" />
                @endif
            </div>
        </div>
        <div class="col-4">
            <div>
                @if($invoice->status == 'pagata')
                    <x-input-label for="release_date" :value="__('Data')" icon="bi bi-calendar" />
                    <x-text-input id="release_date" name="release_date" type="text" class=" input_disabled mt-1 block w-full" required autocomplete="release_date" value="{{$invoice->release_date}}" disabled />
                @else
                    <x-input-label for="release_date" :value="__('Data')" icon="bi bi-calendar" />
                    <x-text-input id="release_date" name="release_date" type="text" class="mt-1 block w-full" required autocomplete="release_date" />
                    <x-input-error class="mt-2" :messages="$errors->get('release_date')" />
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div>
                @if($invoice->status == 'pagata')
                    <x-input-label for="description" :value="__('Descrizione')" icon="bi bi-card-text" />
                    <x-text-input id="description" name="description" type="text" class=" input_disabled mt-1 block w-full" required autocomplete="description" value="{{$invoice->description}}" disabled />
                @else
                    <x-input-label for="description" :value="__('Descrizione')" icon="bi bi-card-text" />
                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" required autocomplete="description" value="{{$invoice->description}}" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                @endif
            </div>
        </div>
        <div class="col-4">
            <x-input-label for="" :value="__('Stato della Fattura')" icon="bi bi-sliders" />
            <select name="" class="mt-1 form-select rounded-md shadow-sm" style="height: 42px!important;" onchange="updateStatus(this)">
                <option value="in attesa" @if($invoice->status == 'in attesa') selected @endif>In attesa</option>
                <option value="pagata" @if($invoice->status == 'pagata') selected @endif>Pagata</option>
                <option value="scaduta" @if($invoice->status == 'scaduta') selected @endif>Scaduta</option>
                <option value="annullata" @if($invoice->status == 'annullata') selected @endif>Annullata</option>
            </select>
        </div>
    </div>
    <div class="flex justify-between items-center gap-4">
        <div>

        </div>
        @if($invoice->status == 'in attesa')
            <x-primary-button>{{ __('Modifica i dati della fattura') }}</x-primary-button>
        @endif
    </div>
</form>
