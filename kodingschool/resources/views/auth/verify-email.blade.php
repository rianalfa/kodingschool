<x-app-layout>
    <x-card.centered class="w-2/5">
        <div class="mb-4 text-gray-800">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button.primary type="submit">
                        {{ __('Resend Verification Email') }}
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
