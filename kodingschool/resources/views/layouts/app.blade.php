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
        <div class="flex h-screen bg-gray-100 overflow-y-auto">
            <div class="flex flex-col flex-1 overflow-x-hidden">
                <x-header.nav title=""></x-header.nav>
                <main class="h-full overflow-y-auto pt-4">
                    <div class="xl:container mb-6 px-4 pt-2 md:px-6 lg:px-8 mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @livewire('livewire-ui-modal')

        <script type="text/javascript">
            window.addEventListener('swal',function(e) {
                console.log(e.detail);

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

        @if (session()->has('message'))
            <x-modal.base id="flashmessage" title="" style="display: block;">
                <x-modal.body>
                    {{ session('message') }}
                </x-modal.body>
            </x-modal.base>
        @endif

        @livewireScripts
        @stack('scripts')
    </body>
</html>
