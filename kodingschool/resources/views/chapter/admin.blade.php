<div>
    <x-modal.base id="modalTambahChapter" title="Bab Baru">
        <x-modal.body>
            <div>
                <x-input.label value="Judul Bab" />
                <x-input.text wire:model.defer="name" required autofocus />
                @error('name') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Nomor Bab" />
                <x-input.text wire:model.defer="number" required />
                @error('number') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </x-modal.body>
        <x-modal.footer>
            <x-button.primary wire:click="addNewChapter">Tambah Bab Baru</x-button.primary>
        </x-modal.footer>
    </x-modal.base>
</div>
