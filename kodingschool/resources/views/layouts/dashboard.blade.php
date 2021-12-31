<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Koding School</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-gray-100" :class="{ 'overflow-hidden': isSideMenuOpen }">
            <!-- @include('components.sidebar.nav') -->
            <div class="flex flex-col flex-1 overflow-x-hidden">
                <!-- @include('components.header.nav') -->
                <main class="h-full overflow-y-auto pt-4">
                    <div class="xl:container px-4 pb-8 pt-4 md:px-6 lg:px-8 mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @livewireScripts
        <script src="{{ mix('js/livewire-handler.js') }}"></script>
    </body>
</html>
