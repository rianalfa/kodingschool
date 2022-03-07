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
            <x-input.textarea wire:model.defer="language.description"></x-input.textarea>
            <x-input.error for="language.description" />
        </div>
        <div class="mt-4">
            <x-input.label value="Ekstensi Bahasa" />
            <x-input.text wire:model.defer="language.type" required />
            <x-input.error for="language.type" />
        </div>
        <div class="mt-4">
            <x-input.label value="Ikon Bahasa" />
            <x-input.file wire:model.defer="image" />
            <x-input.error for="image" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary wire:click="saveLanguage">Simpan</x-button.primary>
    </x-modal.footer>
</div>
