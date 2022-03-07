<div>
    <x-card.base>
        <p class="text-xl font-bold text-center">{{ $chapter->name }}</p>
        <p class="font-bold mt-4">Deskripsi:</p>
        <p class="mt-2">
            {{ $chapter->description}}
        </p>
        <div class="flex flex-col mt-8">
            @if (auth()->user()->hasRole('admin'))
                <x-button.primary class="ml-auto mb-4"
                    wire:click="$emit('openModal', 'matter.modal-matter', {{ json_encode([
                        'chapter' => $chapter->id
                    ]) }})">
                    Tambah Materi
                </x-button.primary>
            @endif

            @livewire('matter.grid', ['chapterId' => $chapter->id])
        </div>
    </x-card.base>
</div>
