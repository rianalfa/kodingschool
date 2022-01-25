<x-jet-dropdown-link href="{{ $notification->data['link'] }}">
    <p class="mb-2">{{ $notification->data['message'] }}</p>
    <p class="italic text-xs text-gray-500 my-1">
        {{ $notification->created_at->format('d M Y H:i') }} WIB
    </p>
</x-jet-dropdown-link>
