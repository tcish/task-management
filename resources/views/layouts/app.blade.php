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
        
        <!-- bootstrap css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">

        <!-- datatable css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />

        <!-- tippy css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.1/tippy.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .custom-bg {
                background-size: 100% 100%;
                background-position: 0px 0px, 0px 0px, 0px 0px, 0px 0px, 0px 0px;
                background-image: repeating-linear-gradient(315deg, #00FFFF2E 92%, #073AFF00 100%), repeating-radial-gradient(75% 75% at 238% 218%, #00FFFF12 30%, #073AFF14 39%), radial-gradient(99% 99% at 109% 2%, #00C9FFFF 0%, #073AFF00 100%), radial-gradient(99% 99% at 21% 78%, #7B00FFFF 0%, #073AFF00 100%), radial-gradient(160% 154% at 711px -303px, #2000FFFF 0%, #073AFFFF 100%);
                min-height: 100vh;
            }
        </style>

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- jquery -->
        <script type="module" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- bootstrap js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- popper & tippy js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.1/tippy.umd.min.js"></script>

        <!-- datatable js -->
        <script type="module" src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

        @stack('scripts')
    </body>
</html>
