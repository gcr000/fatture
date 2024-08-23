<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    @include('customers.partials.update-customer-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    @include('customers.partials.send-new-invoice-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                <div class="max-w-7xl">
                    @include('customers.partials.list-customer-invoices')
                </div>
            </div>
        </div>
    </div>



    <script>
        $(function() {

            /*$.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{url('get_customer')}}/" + ui.item.id,
                        method: 'GET',
                        success: function(data) {
                            setTimeout(function() {
                                result.innerHTML = data;
                            }, 500);
                        },
                        error: function(err) {
                            console.log('err')
                        }
                    });*/
            });
    </script>
</x-app-layout>
