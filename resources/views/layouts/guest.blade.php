<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Odecci Ticketing') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @livewireStyles
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <main class="relative">
            <div class="odc-bg overflow-hidden min-h-screen flex flex-row sm:justify-center items-center sm:pt-0 bg-gray-100 dark:bg-gray-900">
                <div
                    class="w-3/6 h-[100vh] sm:max-w-full relative grid grid-rows-3 gap-0 justify-center z-20 pointer-events-none">
                    <img
                        class="middle scale-[.7]"
                        src="{{ asset('storage/img/logo-full.svg')}}" alt="odc-logo-full">
                    <div class="footer flex flex-col items-center justify-end mb-6 text-sm">
                        <p class="text-blue-secondary">
                            © {{date('Y')}} Odecci Solutions Inc. All Rights Reserved
                        </p>
                        <p class="text-gray-dark">Version 1.0.0</p>
                    </div>
                </div>

                <div class="odc-bg-overlay w-3/6 h-[100vh] sm:max-w-full flex sm:justify-center items-center px-6 sm:px-28 py-4 bg-gradient-to-br from-blue-primary to-blue-secondary dark:bg-gray-800 shadow-md overflow-hidden">
                    {{ $slot }}
                </div>
            </div>
            <div class="odc-bg-logo"></div>
        </main>
    @livewireScripts
    </body>
</html>
