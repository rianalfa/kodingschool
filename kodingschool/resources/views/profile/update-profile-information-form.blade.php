<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        Informasi Profil
    </x-slot>

    <x-slot name="description">
        Ubah informasi profilmu.
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <!-- Current Profile Photo -->
                <div class="flex justify-center mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="border-2 border-gray-300 rounded-full h-28 w-28 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="flex justify-center mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="flex justify-center mt-4">
                    <x-button.secondary class="text-xs py-1 px-2" x-on:click.prevent="$refs.photo.click()">
                        Unggah Foto
                    </x-button.secondary>

                    @if ($this->user->profile_photo_path)
                        <x-button.error class="text-xs ml-2 py-1 px-2" wire:click="deleteProfilePhoto">
                            Hapus Foto
                        </x-button.error>
                    @endif
                </div>

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Nama" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="Email" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="username" value="Username" />
            <x-jet-input id="username" type="username" class="mt-1 block w-full" wire:model.defer="state.username" />
            <x-jet-input-error for="username" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved" wire:loading>
            Menyimpan...
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            Simpan
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
