<div>
    <x-modal.body>
        <p class="text-red-500">Apakah Anda yakin ingin menghapus materi {{ $name }}</p>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.error wire:click="deleteMatter">Yakin</x-button.error>
        <x-button.black class="ml-2" wire:click="$emit('closeModal')">Tidak</x-button.black>
    </x-modal.footer>
</div>
