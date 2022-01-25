<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input.label for="name" value="{{ __('Nama') }}" />
                <x-input.text id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-input.label for="username" value="{{ __('Username') }}" />
                <x-input.text id="username" type="text" name="username" :value="old('username')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-input.label for="email" value="{{ __('Email') }}" />
                <x-input.text id="email" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-input.label for="password" value="{{ __('Password') }}" />
                <x-input.text id="password" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-input.label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input.text id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-800 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-800 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-800 hover:text-gray-900" href="{{ route('home') }}">
                    {{ __('Sudah daftar?') }}
                </a>

                <x-button.black type="submit" class="ml-3">
                    {{__('Registrasi')}}
                </x-button.black>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
