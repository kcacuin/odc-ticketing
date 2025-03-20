<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Odecci Support Application') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="shortcut icon" href="{{ asset('storage/img/odc-favicon.svg') }}" type="image/x-icon">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/css/build.css', 'resources/js/app.js'])
        <x-rich-text::styles theme="richtextlaravel" data-turbo-track="false" />
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <main class="relative">
            <div class="odc-bg overflow-hidden min-h-screen flex flex-row sm:justify-center items-center sm:pt-0 bg-gray-100 dark:bg-gray-900">
                <div
                    class="hidden sm:grid w-1/2 h-[100vh] sm:max-w-full relative grid-rows-3 gap-0 justify-center z-20 pointer-events-none">
                    <img
                        class="middle scale-[.7]"
                        src="{{ asset('storage/img/logo-full.svg')}}" alt="odc-logo-full">
                    <div class="footer flex flex-col items-center justify-end mb-6 text-xs">
                        <p class="text-blue-secondary">
                            © {{date('Y')}} Odecci Solutions Inc. All Rights Reserved
                        </p>
                        <p class="text-gray-dark">Version 1.0.0</p>
                    </div>
                </div>

                <div class="odc-bg-overlay w-full h-[100vh] sm:w-1/2 flex mx-auto justify-center items-center px-6 sm:px-6 py-4 bg-gradient-to-br from-blue-primary to-blue-secondary dark:bg-gray-800 shadow-md overflow-hidden overflow-y-auto">
                    {{ $slot }}
                </div>

                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 sm:hidden footer flex flex-col items-center justify-end mb-6 text-center text-xs">
                    <p class="text-slate-200">
                        © {{date('Y')}} Odecci Solutions Inc. All Rights Reserved
                    </p>
                    <p class="text-slate-300">Version 1.0.0</p>
                </div>
            </div>

            <div class="odc-bg-logo"></div>

        </main>
    @livewireScripts
    </body>
</html>
