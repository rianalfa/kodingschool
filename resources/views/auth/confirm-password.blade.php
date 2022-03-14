<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-800">
            {{ __('Silahkan konfirmasi passwordmu.') }}
        </div>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-input.label for="password" value="{{ __('Password') }}" />
                <x-input.text id="password" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button.primary class="ml-4">
                    {{ __('Konfirmasi') }}
                </x-button.primary>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
