<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-input.label for="email" value="{{ __('Email') }}" />
                <x-input.text id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-input.label for="password" value="{{ __('Password') }}" />
                <x-input.text id="password" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-input.label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input.text id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
