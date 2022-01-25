<x-app-layout>
    <div class="grid grid-cols-3 gap-2">
        <div class="col-span-2">
            <x-card.base title="Koding School">
                Ini penjelasan
            </x-card.base>
        </div>
        <div>
            <x-card.base title="Login">
                <div class="flex">
                    <form class="w-full" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-input.label for="email" value="{{ __('Email') }}" />
                            <x-input.text id="email" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input.label for="password" value="{{ __('Password') }}" />
                            <x-input.text id="password" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-input.checkbox text="{{ __('Ingat saya') }}" id="remember_me" name="remember" />
                            </label>
                        </div>

                        <div class="grid grid-cols-5 gap-0">
                            <div class="flex items-center mt-4">
                                <x-anchor.primary href="{{ route('register') }}">
                                    {{__('Register')}}
                                </x-anchor.primary>
                            </div>
                            <div class="col-span-4">
                                <div class="flex items-center justify-end mt-4">
                                    @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-800 hover:text-gray-900" href="{{ route('password.request') }}">
                                            {{ __('Lupa password?') }}
                                        </a>
                                    @endif

                                    <x-button.black type="submit" class="ml-4">
                                        {{ __('Log in') }}
                                    </x-button.black>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </x-card.base>
        </div>
    </div>
</x-app-layout>
