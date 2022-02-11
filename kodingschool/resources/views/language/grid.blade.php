<div class="grid grid-cols-3 gap-2">
    <div class="col-span-{{ auth()->user()->hasRole('user') ? '2' : '3' }}">
        <div class="relative px-3">
            <p class="text-3xl text-bold text-gray-800 font-bold text-center">Bahasa</p>
            <x-separator />

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($languages as $language)
                    <x-study.language :language="$language" />
                @endforeach
            </div>

            @role('admin')
                <div class="fixed bottom-10 right-10">
                    <x-button.primary class="text-2xl md:text-4xl lg:text-6xl rounded-full"
                        wire:click="$emit('openModal', 'language.modal-language')">
                        <i class="fas fa-plus"></i>
                    </x-button.primary>
                </div>
            @endrole
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('.btn-dropdown').click(function(e) {
                    e.preventDefault();
                });
            });
        </script>
    </div>

    @role('user')
        @livewire('planner')
    @endrole
</div>
