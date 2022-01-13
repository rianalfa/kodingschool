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
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-gray-100">
            <div class="flex flex-col flex-1 overflow-hidden">
                <x-header.nav title=""></x-header.nav>

                {{ $slot }}

                @livewire('matter.footer')
            </div>
        </div>

        @livewire('livewire-ui-modal')

        <script type="text/javascript">
            window.addEventListener('swal',function(e) {
                Swal.fire(e.detail);
            });

            window.addEventListener('modal', function(e) {
                if (e.detail.type=='open') {
                    document.getElementById(e.detail.id).style.display='block';
                } else {
                    document.getElementById(e.detail.id).style.display='none';
                }
            });
        </script>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
