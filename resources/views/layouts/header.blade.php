<div>
    <nav class="bg-sky-700 border-b shadow shadow-sky-200">
        <div class="xl:container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-white">
                        <div class="hidden md:block">
                            <x-logo.text />
                        </div>
                        <div class="md:hidden font-bold text-xl capitalize">
                            {{ $title }}
                        </div>
                    </div>
                    @auth
                        <div class="hidden md:block ">
                            <div class="ml-10 flex items-stretch space-x-4 h-16">
                                {{ $slot }}
                            </div>
                        </div>
                    @endauth
                </div>
                @auth
                    <div class="flex">
                        <div class="flex items-center">
                            @livewire('notifications.header', key($user->id))
                        </div>
                        <div class="block mx-3">
                            <ul class="flex items-center">
                                <x-header.profile />
                            </ul>
                        </div>
                        <div class="-mr-2 flex md:hidden">
                            <button type="button" x-on:click="toggleSideMenu"
                                class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300"
                                aria-controls="mobile-menu" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>

                                <svg x-show="!isSideMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg x-show="isSideMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" x-cloak />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

    </nav>
</div>
