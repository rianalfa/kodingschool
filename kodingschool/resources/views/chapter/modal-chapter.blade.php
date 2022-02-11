<div>
    <x-modal.header>Bab</x-modal.header>
    <x-modal.body>
        <div>
            <x-input.label value="Judul Bab" />
            <x-input.text wire:model.defer="chapter.name" required autofocus />
            <x-input.error for="chapter.name" />
        </div>
        <div class="mt-4">
            <x-input.label value="Nomor Bab" />
            <x-input.text wire:model.defer="chapter.number" required />
            <x-input.error for="chapter.number" />
        </div>
        <div class="mt-4">
            <x-input.label value="Deskripsi" />
            <x-input.textarea wire:model.defer="chapter.description" required></x-input.textarea>
            <x-input.error for="chapter.description" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary wire:click="addNewChapter">Simpan</x-button.primary>
    </x-modal.footer>
</div>
