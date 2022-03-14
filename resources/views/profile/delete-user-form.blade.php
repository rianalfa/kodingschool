<x-jet-action-section>
    <x-slot name="title">
        Hapus Akun
    </x-slot>

    <x-slot name="description">
        Hapur permanen akun.
    </x-slot>

    <x-slot name="content">
        <div class="flex justify-end mt-5">
            <x-button.error wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                Hapus Akun
            </x-button.error>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                Hapus Akun
            </x-slot>

            <x-slot name="content">
                Apakah Anda yakin ingin menghapus akun Anda? Data tidak akan bisa dikembalikan setelah dihapus.

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input.text type="password" placeholder="Password" x-ref="password"
                        wire:model.defer="password" wire:keydown.enter="deleteUser" />
                    <x-input.error for="password" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    Batal
                </x-button.secondary>

                <x-button.error class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    Hapus Akun
                </x-button.error>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
