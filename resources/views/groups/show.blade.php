<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dettaglio Gruppo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-8">
                                <h5 class="title">Gruppo: <b>{{$group->name}}</b></h5>
                                <p>Clienti associati: <b>{{$group->dimension}}</b></p>
                            </div>
                            <div class="col-4 text-end">
                                <a class="text-black hover:text-red-600" href="{{url('/groups') }}"> <i class="bi bi-arrow-left"></i> Gruppi</a>
                            </div>
                        </div>

                        <form method="post" action="{{ route('groups.update', $group) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div class="row">
                                <div class="col-10">
                                    <x-input-label for="name" :value="__('Nome Gruppo')" icon="bi bi-person-lines-fill" />
                                    <x-text-input value="{{$group->name}}" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                </div>

                                <div class="col-2 text-end">
                                    <button type="submit" style="height: 42px" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">Salva Gruppo</button>
                                </div>
                            </div>
                        </form>

                        <div class="row mt-4">

                            <div class="col-6 mt-4 border-end">
                                <h5 class="title">Clienti associati</h5>
                                @foreach(\App\Models\Customer::query()->where('group_id', $group->id)->orderBy('surname')->get() as $item)
                                    <div class="row border-bottom">
                                        <div class="col-3">
                                            <input type="checkbox" id="check_{{$item->id}}" onclick="selectCustomer(this)" checked>
                                        </div>
                                        <div class="col-8" onclick="toggleCheckbox({{$item->id}})" style="cursor:pointer;">
                                            {{$item->surname}} {{$item->name}}
                                        </div>
                                    </div>
                                @endforeach
                                @if(count(\App\Models\Customer::query()->where('group_id', $group->id)->get()) == 0)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <i>Nessun cliente associato</i>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-6 mt-4">
                                <h5 class="title">Clienti da associare</h5>
                                @foreach(\App\Models\Customer::query()->where('group_id', NULL)->orderBy('surname')->get() as $item)
                                    <div class="row border-bottom">
                                        <div class="col-3">
                                            <input type="checkbox" id="check_{{$item->id}}" onclick="selectCustomer(this)">
                                        </div>
                                        <div class="col-8" onclick="toggleCheckbox({{$item->id}})" style="cursor:pointer;">
                                            {{$item->surname}} {{$item->name}}
                                        </div>
                                    </div>
                                @endforeach
                                @if(count(\App\Models\Customer::query()->where('group_id', NULL)->get()) == 0)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <i>Nessun cliente da associare</i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectCustomer(checkbox) {

            let id = checkbox.id.split('_')[1];
            if (checkbox.checked) {
                manageCustomer(id, '{{$group->id}}', 'add');
            } else {
                manageCustomer(id, '{{$group->id}}', 'remove');
            }
        }

        function toggleCheckbox(itemId) {
            var checkbox = document.getElementById('check_' + itemId);
            checkbox.checked = !checkbox.checked;
            selectCustomer(checkbox);
        }

        function manageCustomer(customer_id, group_id, action) {
            $.ajax({
                url: '{{url('/groups_manage_customer')}}',
                type: 'POST',
                data: {
                    customer_id: customer_id,
                    group_id: group_id,
                    action: action,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    console.log(response);
                    window.location.reload();
                }
            });
        }
    </script>
</x-app-layout>
