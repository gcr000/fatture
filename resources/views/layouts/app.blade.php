<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Autocomplete -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>

            :root {
                --custom-color1: #F7EFE5;
                --custom-color2: #E2BFD9;
                --custom-color3: #C8A1E0;
                --custom-color4: #674188;
            }

            .ui-autocomplete {
                z-index: 5000;
            }
            a {
                text-decoration: none!important;
            }

            .input_disabled {
                background-color: #cecece;
                cursor: not-allowed;
            }

            .confirm_update_button {
                color: red;
                cursor: pointer;
                border: 1px solid red;
                border-radius: 3px;
                padding: 1px 10px;
                display: none;
            }

            .confirm_update_button:hover {
                background-color: red;
                color: white;
            }

            * {
                color: var(--custom-color4)!important;
            }

            main {
                background-color: var(--custom-color2);
            }

            .nuovo_elemento {
                border: 1px solid var(--custom-color4);
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
            }

            .nuovo_elemento:hover {
                background-color: var(--custom-color4);
                color: white!important;
            }

            .nuovo_elemento:hover .nuovo_elemento_icon {
                color: white!important;
            }

            /* Cambia il colore di sfondo delle opzioni */
            /*.ui-menu-item {
                background-color: #b925da; !* Colore di sfondo personalizzato *!
            }*/

            /* Cambia il colore di sfondo quando si passa sopra le opzioni */
            .ui-menu-item-wrapper.ui-state-active {
                background-color: var(--custom-color1);
                color: white;
                border-bottom: 1px solid var(--custom-color1);
                border-top: 1px solid var(--custom-color1);
                border-right: 1px solid lightgrey;
                border-left: 1px solid lightgrey;

            }

            input {
                outline: none !important;
                box-shadow: none !important; /* Rimuove qualsiasi ombra */
            }

            /* Rimuove l'outline e imposta un nuovo stile per gli elementi in focus */
            input:focus, select:focus, textarea:focus, button:focus {
                outline: none !important; /* Rimuove il contorno */
                box-shadow: none !important; /* Rimuove l'ombra */
                border: 1px solid var(--custom-color4) !important; /* Cambia il colore del bordo */
            }

        </style>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    </body>
</html>
