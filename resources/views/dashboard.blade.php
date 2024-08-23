<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container-fluid">

                        <div class="row mb-4 pb-4">
                            <div class="col-10">
                                @foreach($errors->all() as $item)
                                    <div x-data="{ show: true }"
                                         x-show="show"
                                         x-transition
                                         x-init="setTimeout(() => show = false, 4000)"
                                         class="alert alert-danger" role="alert"
                                    >
                                        {{ $item }}
                                    </div>
                                @endforeach

                                <h5 class="title">Vai alla scheda del cliente</h5>
                                <input placeholder="Cerca per cognome, email o numero di telefono..." class="form-control" id="customer_search_input" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="2048" tabindex="1">
                            </div>
                            <div class="col-2 text-end">
                                <label for="" class="form-label">&nbsp;</label> &nbsp;<br>

                                <button id="new_customer_btn" type="button" class="btn nuovo_elemento" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="bi bi-person-plus-fill nuovo_elemento_icon"></i> Nuovo cliente
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 mt-4 pb-4">
                            <h5 class="title">Elenco clienti</h5>
                            @foreach(\App\Models\Customer::query()->orderBy('surname')->get() as $customer)
                                <div class="row border-bottom">
                                    <div class="col-3" style="white-space: nowrap">
                                        {{ $customer->surname }} {{ $customer->name }}
                                    </div>
                                    <div class="col-3 ">
                                        {{ $customer->email }}
                                    </div>
                                    <div class="col-3 text-center">
                                        {{ $customer->phone }}
                                    </div>
                                    <div class="col-2 text-end">
                                        @if($customer->group)
                                            {{$customer->group->name}}
                                        @else
                                            <span class="" style="color: var(--custom-color3)!important;">Nessun gruppo</span>
                                        @endif
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                            @if(\App\Models\Customer::query()->count() === 0)
                                <div class="row">
                                    <div class="col-12">
                                        <i>Nessun cliente salvato</i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuovo cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if(session('new_customer'))
                        <div x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 1000)"
                             class="alert alert-success" role="alert"
                        >
                            Cliente creato con successo
                        </div>
                    @endif

                    <form method="post" action="{{ route('customers.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div>
                            <x-input-label for="name" :value="__('Nome')" icon="bi bi-person-lines-fill" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <x-input-label for="surname" :value="__('Cognome')" icon="bi bi-person-lines-fill" />
                            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" autocomplete="surname" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" icon="bi bi-envelope" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Telefono')" icon="bi bi-telephone" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" required autocomplete="phone" />
                        </div>

                        <div>
                            {{--<x-input-label for="reload" :value="__('Redirect')" icon="bi bi-arrow-clockwise" />--}}
                            <x-checkbox-input id="new_customer" name="new_customer" value="1">
                                {{ __('Al salvataggio, crea subito un nuovo cliente') }}
                            </x-checkbox-input>

                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salva Cliente') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            if ("{{session('new_customer')}}") {
                document.getElementById('new_customer_btn').click();
            }

            let search_input = document.getElementById('customer_search_input');
            let customer_id = document.getElementById('customer_id');
            let generate_invoice = document.getElementById('generate_invoice');
            let details = document.getElementById('details');
            let result = document.getElementById('result');
            let data_customer = document.getElementsByClassName('data_customer');

            for (let i = 0; i < data_customer.length; i++) {
                data_customer[i].addEventListener('input', function() {
                    generate_invoice.disabled = true;
                    details.disabled = true;
                });
            }

            /* Gestione degli spazi nel campo di ricerca */
            search_input.addEventListener('keydown', function(event) {
                if (event.key === ' ') {
                    event.preventDefault();
                }
            });
            /* Gestione degli spazi nel campo di ricerca */
            search_input.addEventListener('input', function() {
                // Remove spaces if pasted into the input
                this.value = this.value.replace(/\s+/g, '');
            });

            /* Autocomplete */
            $(search_input).autocomplete({
                source: function(request, response) {
                    if(request.term.length < 3){ //lunghezza minima per la ricerca
                        //clearCustomerInputs();
                        result.innerHTML = '';
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{url('search_customer')}}/",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            if(data.length === 0){
                                toastr.error('Nessun cliente trovato', 'Errore');
                            }
                            response(data);
                        }
                    });
                },
                minLength: 3,
                select: function(event, ui) {
                    // add loader to result div
                    window.location.href = "{{url('customer')}}/" + ui.item.id;
                }
            });

            search_input.addEventListener('input', function() {
                if (search_input.value === '') {
                    result.innerHTML = '';
                }
            });

            function clearCustomerInputs() {
                customer_id.value = '';
                generate_invoice.disabled = true;
                details.disabled = true;
            }
        });
    </script>

</x-app-layout>
