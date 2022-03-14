<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-800">
            {{ __('Lupa password? Jangan khawatir. Masukkan alamat emailmu dibawah ini, kami akan kirimkan tautan untuk mereset passwordmu. Silahkan cek email mu setelahnya.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-input.label for="email" value="{{ __('Email') }}" />
                <x-input.text id="email" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button.primary type="submit">
                    {{ __('Kirim Tautan Reset Password') }}
                </x-button.primary>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
