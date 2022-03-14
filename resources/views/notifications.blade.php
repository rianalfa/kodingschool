<div class="flex-1">
    <x-card.base title="Notifications" class="w-full px-0 py-0 sm:p-0">
        <div class="divide-y">
            @forelse ($notifications as $notification)
                <x-notifications.notification-item :notification="$notification" />
            @empty
                <div class="p-4 text-sm text-gray-400">
                    <p class="text-center italic">Tidak ada notifikasi baru</p>
                </div>
            @endforelse
        </div>
        <div class="m-4 pt-2">
            {{ $notifications->links() }}
        </div>
    </x-card.base>
</div>
