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
    </head>
    <body class="bg-light text-dark">
        <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center py-4 bg-light">
            <div class="mb-4 text-center">
                <a href="/">
                    <x-application-logo class="w-25 h-25 text-secondary" />
                </a>
            </div>
    
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <div class="p-4 bg-white shadow-sm rounded">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>      
</html>
