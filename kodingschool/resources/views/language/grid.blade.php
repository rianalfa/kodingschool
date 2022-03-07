<div class="grid grid-cols-3 gap-2">
    <div class="col-span-{{ auth()->user()->hasRole('user') ? '2' : '3' }}">
        <div class="relative px-3">
            <p class="text-3xl text-bold text-gray-800 font-bold text-center">Bahasa</p>
            <x-separator />

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse ($languages as $language)
                    <x-study.language :language="$language" />
                @empty
                    <x-card.base>
                        <p class="text-xl font-bold text-center w-full mx-auto">Maaf, belum ada bahasa yang tersedia!</p>
                    </x-card.base>
                @endforelse
            </div>

            @if (auth()->user()->hasRole('admin'))
                <div class="fixed bottom-10 right-10">
                    <x-button.primary class="text-2xl md:text-4xl lg:text-6xl rounded-full"
                        wire:click="$emit('openModal', 'language.modal-language')">
                        <i class="fas fa-plus"></i>
                    </x-button.primary>
                </div>
            @endif
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('.btn-dropdown').click(function(e) {
                    e.preventDefault();
                });
            });
        </script>
    </div>

    @if (auth()->user()->hasRole('user'))
        @livewire('user.planner')
    @endif
</div>
