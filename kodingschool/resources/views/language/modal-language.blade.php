<div>
    <x-modal.header>Bahasa</x-modal.header>
    <x-modal.body>
        <div>
            <x-input.label value="Nama Bahasa" />
            <x-input.text wire:model.defer="language.name" required autofocus />
            <x-input.error for="language.name" />
        </div>
        <div class="mt-4">
            <x-input.label value="Deskripsi Bahasa" />
            <x-input.textarea wire:model.defer="language.description" required></x-input.textarea>
            <x-input.error for="language.description" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary wire:click="saveLanguage">Simpan</x-button.primary>
    </x-modal.footer>
</div>
