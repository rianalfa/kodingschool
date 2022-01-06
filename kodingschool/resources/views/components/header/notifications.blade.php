<x-jet-dropdown align="right" width="80">
    <x-slot name="trigger">
        <div x-data="{showUnreadNotifications : true}">
            <button
                class="relative flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition p-1"
                x-on:click="showUnreadNotifications = false; setTimeout(() => {Livewire.emit('readNotifications');}, 2000);">
                <x-icons.bell stroke-width="1" width="24" height="24"></x-icons.bell>
                @if ($totalUnreadNotifications)
                    <div x-show="showUnreadNotifications"
                        class="absolute font-bold -right-1 -top-2 text-xs bg-yellow-500 text-white rounded-full w-6 h-6 flex justify-center items-center transform scale-75">
                        {{ $totalUnreadNotifications }}
                    </div>
                @endif
            </button>
        </div>
    </x-slot>

    <x-slot name="content">
        <ul class="divide-y max-h-96 w-80 scroll-style overflow-y-auto pb-2" id="notif-container">
            @forelse (auth()->user()->unreadNotifications as $n)
                <x-jet-dropdown-link href="{{ $n->data['link'] }}"
                    class="{{ $n->read_at ? __('bg-white') : __('bg-gray-100') }} ">
                    <p>{{ $n->data['message'] }}</p>
                    <p class="italic text-right text-xs text-gray-500 my-1">
                        {{ $n->created_at->format('d M Y H:i') }} WIB
                    </p>
                </x-jet-dropdown-link>
            @empty
                <li class="p-2 text-sm text-gray-500">
                    <p class="text-center italic">No unread notifications</p>
                </li>
            @endforelse
            <x-jet-dropdown-link href="#" class="font-bold text-center text-gray-600">
                See All Your Notifications
            </x-jet-dropdown-link>
        </ul>
    </x-slot>
</x-jet-dropdown>
