<div class="grid grid-cols-3">
    @role('user')
        <div class="col-span-2">
            <p class="text-3xl text-bold text-gray-800 font-bold text-center">{{ $language->name }}</p>
            <x-separator />

            @livewire('chapter.grid', ['language' => $language])
        </div>
        <div></div>
    @else
        <div class="relative col-span-3">
            <p class="text-3xl text-bold text-gray-800 font-bold text-center mb-3">{{ $language->name }}</p>
            <x-separator />

            <livewire:chapter.grid :language="$language" key="{{ now() }}" />

            <div class="absolute top-0 right-0">
                <x-button.primary wire:click="openModal('modalTambahChapter')">
                    Tambah Bab Baru
                </x-button.primary>
                <x-button.primary class="ml-2" wire:click="openModal('modalTambahMatter')">
                    Tambah Materi Baru
                </x-button.primary>
            </div>

            @livewire('chapter.admin', ['id' => $language->id])

            @livewire('matter.admin', ['id' => $language->id])
        </div>
    @endrole
</div>
