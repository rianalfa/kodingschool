<div>
    <x-card.base>
        <p class="text-xl font-bold text-center">{{ $chapter->name }}</p>
        <p class="font-bold mt-4">Deskripsi:</p>
        <p class="mt-2">
            {{ $chapter->description}}
        </p>
        <div class="flex flex-col mt-8">
            @role('admin')
                <x-button.primary class="ml-auto mb-4"
                    wire:click="$emit('openModal', 'matter.modal-matter', {{ json_encode([
                        'chapter' => $chapter->id
                    ]) }})">
                    Tambah Materi
                </x-button.primary>

                <div class="fixed bottom-10 right-10">
                    <x-button.primary class="text-2xl md:text-4xl lg:text-6xl rounded-full"
                        wire:click="$emit('openModal', 'chapter.modal-chapter', {{ json_encode([
                                    'language' => $chapter->language()->first()->id
                                ]) }})">
                        <i class="fas fa-plus"></i>
                    </x-button.primary>
                </div>
            @endrole

            @if ($chapter->matters()->count()!=0)
                @livewire('matter.grid', ['chapterId' => $chapter->id])
            @else
                <p class="text-center">Maaf, materi untuk bab ini belum tersedia!</p>
            @endif
        </div>
    </x-card.base>
</div>
