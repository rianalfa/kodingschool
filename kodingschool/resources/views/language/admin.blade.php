<div>
    <div class="absolute bottom-0 right-0">
        <x-button.primary class="text-2xl md:text-4xl lg:text-6xl rounded-full" wire:click="openModal('modalTambahBahasa')">
            <i class="fas fa-plus"></i>
        </x-button.primary>
    </div>

    <x-modal.base id="modalTambahBahasa" title="Bahasa Baru">
        <x-modal.body>
            <div>
                <x-input.label value="Nama Bahasa" />
                <x-input.text wire:model.defer="name" required autofocus />
                @error('name') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </x-modal.body>
        <x-modal.footer>
            <x-button.primary wire:click="addNewLanguage">Tambah Bahasa Baru</x-button.primary>
        </x-modal.footer>
    </x-modal.base>
</div>
