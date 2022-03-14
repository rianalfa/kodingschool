<x-card.form class="mx-0 my-0">
    <x-slot name="title">
        Detail Profil
    </x-slot>

    <x-slot name="description">
        Ubah detail profilmu.
    </x-slot>

    <form class="grid grid-cols-6 gap-6" wire:submit.prevent="updateProfileDetailInformation">
        <div class="col-span-6 sm:col-span-4">
            <x-input.label for="year" value="Tingkat" />
            <x-input.text id="year" wire:model.defer="detail.year" type="text" />
            <x-input.error for="detail.year" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-input.label for="class" value="Kelas" />
            <x-input.text id="class" wire:model.defer="detail.class" type="text" />
            <x-input.error for="detail.class" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-input.label for="address" value="Alamat" />
            <x-input.textarea id="address" wire:model.defer="detail.address"></x-input.textarea>
            <x-input.error for="detail.address" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-input.label for="phone" value="Telepon" />
            <x-input.text id="phone" wire:model.defer="detail.phone" type="text" placeholder="628..." />
            <x-input.error for="detail.phone" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-input.label for="motto" value="Motto" />
            <x-input.textarea id="motto" wire:model.defer="detail.motto"></x-input.textarea>
            <x-input.error for="detail.motto" />
        </div>

        <div class="flex col-span-6 justify-end mt-6 items-center">
            <x-jet-action-message class="mr-3" on="saved" wire:loading>
                Menyimpan...
            </x-jet-action-message>

            <x-button.black type="submit" wire:loading.attr="disabled">
                Simpan
            </x-button.black>
        </div>
    </form>
</x-card.form>
