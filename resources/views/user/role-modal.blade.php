<div>
    <x-modal.header>Role</x-modal.header>
    <x-modal.body>
        <div>
            <x-input.label value="Admin" />
            <x-input.checkbox wire:model.defer="role" value="admin" required />
            <x-input.error for="role" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary wire:click="saveRole">Simpan</x-button.primary>
    </x-modal.footer>
</div>
