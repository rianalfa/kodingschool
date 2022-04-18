<div class="grid grid-cols-3 gap-4">
    <div class="col-span-3 lg:col-span-{{ auth()->user()->hasRole('user') ? '2' : '3' }}">
        <div class="relative px-3 {{ auth()->user()->hasRole('admin') ? 'w-full lg:w-2/3 mx-auto' : '' }}">
            <p class="text-3xl text-bold text-gray-800 font-bold text-center">Bahasa</p>
            <x-separator />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-80 lg:max-h-full overflow-y-auto lg:overflow-y-visible">
                @forelse ($languages as $language)
                    <x-study.language :language="$language" />
                @empty
                    <x-card.base>
                        <p class="text-xl font-bold text-center w-full mx-auto">Maaf, belum ada bahasa yang tersedia!</p>
                    </x-card.base>
                @endforelse
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('.btn-dropdown').click(function(e) {
                    e.preventDefault();
                });
            });
        </script>
    </div>

    <div class="col-span-3 lg:col-span-1">
        @if (auth()->user()->hasRole('user'))
            @livewire('user.planner')
        @endif
    </div>
</div>
