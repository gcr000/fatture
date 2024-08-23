<div class="row">
    <div class="col-6">
        <h5 class="title">Dati Cliente</h5>
    </div>
    <div class="col-6 text-end">
        <a class="text-black hover:text-red-600" href="{{url('/customer') .'/'. $invoice->customer->id}}"> <i class="bi bi-arrow-left"></i> Cliente</a>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div>
            <x-input-label for="name" :value="__('Nome')" icon="bi bi-person-lines-fill" />
            <x-text-input type="text" class="mt-1 block w-full input_disabled" :value="old('name', $invoice->customer->name)" readonly autocomplete="name" />
        </div>
    </div>
    <div class="col-6">
        <div>
            <x-input-label for="surname" :value="__('Cognome')" icon="bi bi-person-lines-fill" />
            <x-text-input type="text" class="mt-1 block w-full input_disabled" :value="old('surname', $invoice->customer->surname)" readonly autocomplete="surname" />
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-6">
        <div>
            <x-input-label for="email" :value="__('Email')" icon="bi bi-envelope" />
            <x-text-input type="email" class="mt-1 block w-full input_disabled" :value="old('email', $invoice->customer->email)" readonly autocomplete="username" />
        </div>
    </div>
    <div class="col-6">
        <div>
            <x-input-label for="phone" :value="__('Telefono')" icon="bi bi-telephone" />
            <x-text-input type="text" class="mt-1 block w-full input_disabled" :value="old('phone', $invoice->customer->phone)" readonly autocomplete="phone" />
        </div>
    </div>
</div>
