<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="initData()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Koding School') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        @stack('styles')
    </head>
    <body class="font-sans antialiased overflow-y-hidden">
        @include('sweetalert::alert')
        <x-header.nav title=""></x-header.nav>
        <div class="flex h-screen bg-gray-100 overflow-y-auto" style="padding-bottom: 40px;">
            @livewire('matter.show', ['matter' => $matter])
        </div>
        @livewire('matter.footer')

        <script type="text/javascript">
            window.addEventListener('swal',function(e){
                Swal.fire(e.detail);
            });
        </script>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
