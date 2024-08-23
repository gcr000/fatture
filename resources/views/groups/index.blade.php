<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gruppi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-8">
                                <h5 class="title">Elenco dei Gruppi</h5>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Clienti non associati ad alcun gruppo: <b>{{\App\Models\Customer::query()->whereNull('group_id')->count()}}</b>
                                </p>
                            </div>
                            <div class="col-4 text-end">
                                <button id="new_customer_btn" type="button" class="btn nuovo_elemento" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="bi bi-person-plus-fill nuovo_elemento_icon"></i> Nuovo Gruppo
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            @foreach($groups as $group)
                                <div class="col-3 text-center mb-2">
                                    <div class="card text-center" style="background: var(--custom-color1)">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-center">{{$group->name}}</h5>
                                            <p class="text-muted text-center" style="margin-top: -10px">{{$group->dimension}} clienti</p>
                                            <a onclick='deleteGroup("{{$group->id}}", "{{$group->name}}")' style="cursor: pointer; color: var(--custom-color3)!important;" class="text-red-600 hover:text-red-900 text-center mx-auto">Elimina</a>
                                            |
                                            <a href="{{ route('groups.show', $group->id) }}" class="text-center mx-auto">Dettagli</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">Nuovo Gruppo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('groups.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div>
                            <x-input-label for="name" :value="__('Nome Gruppo')" icon="bi bi-person-lines-fill" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salva Gruppo') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteGroup(id, name) {
            if (confirm('Sei sicuro di voler eliminare il gruppo ' + name + ' e rimuovere l\'associazione di tutti i clienti che ne fanno parte?')) {
                $.ajax({
                    url: "{{url('group_destroy')}}/" + id,
                    method: 'GET',
                    success: function(data) {
                        location.reload();
                    },
                    error: function(err) {
                        console.log('err')
                    }
                });
            }
        }
    </script>
</x-app-layout>
