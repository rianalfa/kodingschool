<div>
    <nav class="bg-white border-b shadow">
        <div class="xl:container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 md:border-b-2 border-white text-gray-600">
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
                        <div class="ml-4 flex items-center mx-3">
                            @livewire('notifications.header', key($user->id))
                        </div>
                        <div class="hidden md:block">
                            <ul class="flex items-center">
                                <x-header.profile />
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

    </nav>
</div>
