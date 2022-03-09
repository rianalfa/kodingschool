    <li>
    <x-jet-dropdown align="right" width="48">
        <x-slot name="trigger">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-10 w-10 rounded-full object-cover bg-white border-2 border-gray-300" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                </button>
            @else
                <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center justify-center bg-sky-100 rounded-full
                         hover:scale-110 focus:scale-110 h-10 w-10 p-2">
                        <i class="fas fa-user text-xl"></i>
                    </button>
                </span>
            @endif
        </x-slot>

        <x-slot name="content">
            <x-jet-dropdown-link href="{{ route('user.profile') }}">
                {{ __('Lihat Profil') }}
            </x-jet-dropdown-link>

            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                {{ __('Atur Profil') }}
            </x-jet-dropdown-link>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-jet-dropdown-link>
            @endif

            <div class="border-t border-gray-100"></div>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-jet-dropdown-link>
            </form>
        </x-slot>
    </x-jet-dropdown>
</li>
