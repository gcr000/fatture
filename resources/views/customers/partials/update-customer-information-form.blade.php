<section>
    <header>
        <div class="row">
            <div class="col-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Profilo') }}
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-top: -10px">
                    {{ __("Aggiorna i dati del profilo del cliente.") }}
                </p>
            </div>
            <div class="col-4">
                <div class="flex justify-end">
                    <a href="{{ route('dashboard') }}" class="text-black hover:text-red-600">
                        <i class="bi bi-arrow-left"></i> {{ __('Torna alla dashboard') }}
                    </a>
                </div>
            </div>
        </div>

    </header>

    <form method="post" action="{{ route('customers.update', $customer) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-6">
                <div>
                    <x-input-label for="name" :value="__('Nome')" icon="bi bi-person-lines-fill" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $customer->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
            </div>
            <div class="col-6">
                <div>
                    <x-input-label for="surname" :value="__('Cognome')" icon="bi bi-person-lines-fill" />
                    <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $customer->surname)" required autocomplete="surname" />
                    <x-input-error class="mt-2" :messages="$errors->get('surname')" />
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <div>
                    <x-input-label for="email" :value="__('Email')" icon="bi bi-envelope" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $customer->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
            </div>
            <div class="col-6">
                <div>
                    <x-input-label for="phone" :value="__('Telefono')" icon="bi bi-telephone" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $customer->phone)" required autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <div>
                    <x-input-label for="email" :value="__('Registrato il')" icon="bi bi-calendar" />
                    <x-text-input type="text" class="mt-1 block w-full input_disabled" :value="date('d/m/Y H:i', strtotime($customer->created_at))"/>
                </div>
            </div>
            <div class="col-6">
                <div>
                    <x-input-label for="phone" :value="__('Gruppo di appartenenza')" icon="bi bi-people" />
                    <select name="group_id" class="mt-1 form-select rounded-md shadow-sm" style="height: 42px!important;">
                        <option value="null">Nessun gruppo</option>
                        @foreach(\App\Models\Group::query()->get() as $group)
                            <option value="{{$group->id}}" {{$customer->group_id == $group->id ? 'selected' : ''}}>{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center gap-4">
            <x-primary-button>{{ __('Aggiorna') }}</x-primary-button>

            <button class="btn nuovo_elemento" type="button" onclick="deleteCustomer()">Cancella</button>
        </div>

        @if(session('customer-updated'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition
                 x-init="setTimeout(() => show = false, 2000)"
                 class="bg-green-100 border border-green-400 text-green-900 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Ben fatto!</strong>
                <span class="block sm:inline">Dati aggiornati correttamente</span>
            </div>
        @endif
    </form>
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
</script>
