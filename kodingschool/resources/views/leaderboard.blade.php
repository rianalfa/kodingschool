<div>
    <div class="flex justify-center mb-4">
        <x-button.black class="focus:bg-gray-500 rounded-r-none w-28"
            wire:click="boardChange('day')">Hari Ini</x-button.black>
        <x-button.black class="focus:bg-gray-500 rounded-none w-28"
            wire:click="boardChange('month')">Bulan Ini</x-button.black>
        <x-button.black class="focus:bg-gray-500 rounded-l-none w-28"
            wire:click="boardChange('total')">Sepanjang Waktu</x-button.black>
    </div>

    <div class="w-5/6 max-w-5xl mx-auto">
        <x-card.base>
            @if (count($leaderboard))
                @foreach ($leaderboard as $leader)
                    @if ($loop->iteration==1)
                        <div class="grid grid-cols-3 gap-2 mx-auto mb-4">
                            <p class="fas fa-medal text-5xl text-yellow-400 m-auto"></p>
                            <p class="text-5xl font-bold text-center">{{ $leader->name }}</p>
                            <p class="text-5xl font-bold text-center">{{ $leader->points }}</p>
                        </div>
                    @elseif ($loop->iteration==2)
                        <div class="grid grid-cols-3 gap-2 mx-auto mb-4">
                            <p class="fas fa-medal text-3xl text-slate-300 m-auto"></p>
                            <p class="text-3xl font-bold text-center">{{ $leader->name }}</p>
                            <p class="text-3xl font-bold text-center">{{ $leader->points }}</p>
                        </div>
                    @elseif ($loop->iteration==3)
                        <div class="grid grid-cols-3 gap-2 mx-auto mb-4">
                            <p class="fas fa-medal text-xl text-orange-700 m-auto"></p>
                            <p class="text-xl font-bold text-center">{{ $leader->name }}</p>
                            <p class="text-xl font-bold text-center">{{ $leader->points }}</p>
                        </div>
                    @else
                        <div class="grid grid-cols-3 gap-2 mx-auto mb-4">
                            <p class="font-bold text-center">{{ $loop->iteration }}</p>
                            <p class="font-bold text-center">{{ $leader->name }}</p>
                            <p class="font-bold text-center">{{ $leader->points }}</p>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-xl font-bold text-center">Sayang sekali, belum ada peringkat untuk hari ini :(</p>
            @endif
        </x-card.base>
    </div>
</div>
