<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="initData()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Koding School') }}</title>
        <link rel="icon" href="{{ asset('images/KS.png') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        @stack('styles')
    </head>
    <body class="font-sans antialiased overflow-y-hidden">
        <div class="flex h-screen bg-gray-100 overflow-y-auto" :class="{ 'overflow-hidden': isSideMenuOpen }">
            <x-sidebar.nav></x-sidebar.nav>
            <div class="flex flex-col flex-1 overflow-x-hidden">
                <x-header.nav title=""></x-header.nav>
                <main class="h-full overflow-y-auto pt-4">
                    <div class="xl:container mb-6 px-4 md:px-6 lg:px-8 mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @livewire('livewire-ui-modal')

        @livewireScripts
        <script src="{{ mix('js/livewire-handler.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>
