<x-app-layout>
    <x-card.centered class="w-2/5">
        <div class="mb-4 text-gray-800">
            {{ __('Terima kasih sudah mendaftar! Sebelum kamu mulai menggunakan aplikasi ini, Silahkan konfirmasi emailmu dengan menekan tombol yang ada pada email yang telah kami kirimkan ke emailmu. Bila kamu tidak menemukan emailnya, kami dapat mengirim ulang email konfirmasi.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Email konfirmasi yang baru telah kami kirimkan ke alamat emailmu.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button.primary type="submit">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-button.primary>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-button.black type="submit">
                    {{ __('Log Out') }}
                </x-button.black>
            </form>
        </div>
    </x-card.centered>
</x-app-layout>
