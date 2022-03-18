<div class="w-full lg:w-5/6 mx-auto">
    <div class="flex justify-center mb-4">
        <x-button.black class="focus:bg-gray-500 rounded-r-none w-28{{ $type=='day' ? ' bg-gray-500' : '' }}"
            wire:click="boardChange('day')">Hari Ini</x-button.black>
        <x-button.black class="focus:bg-gray-500 rounded-none w-28{{ $type=='month' ? ' bg-gray-500' : '' }}"
            wire:click="boardChange('month')">Bulan Ini</x-button.black>
        <x-button.black class="focus:bg-gray-500 rounded-l-none w-28{{ $type=='total' ? ' bg-gray-500' : '' }}"
            wire:click="boardChange('total')">Sepanjang Waktu</x-button.black>
    </div>

    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-4 lg:col-span-3 h-80 lg:h-max overflow-y-auto lg:overflow-y-visible">
            <x-card.base class="sm:py-9">
                @forelse ($leaderboard as $leader)
                    @if ($loop->iteration==1)
                        <a class="grid grid-cols-3 gap-2 mx-auto mb-4" href="{{ route('user.profile', $leader->username) }}">
                            <p class="fas fa-medal text-3xl lg:text-5xl text-yellow-400 m-auto"></p>
                            <div class="flex flex-col lg:flex-row col-span-2">
                                <p class="text-2xl lg:text-5xl font-bold text-center lg:w-1/2">{{ $leader->name }}</p>
                                <p class="text-2xl lg:text-5xl font-bold text-center lg:w-1/2">{{ $leader->points }}</p>
                            </div>
                        </a>
                        <div class="pb-5">
                            <div class="border-t border-gray-300"></div>
                        </div>
                    @elseif ($loop->iteration==2)
                        <a class="grid grid-cols-3 gap-2 mx-auto mb-4" href="{{ route('user.profile', $leader->username) }}">
                            <p class="fas fa-medal text-2xl lg:text-3xl text-slate-300 m-auto"></p>
                            <div class="flex flex-col lg:flex-row col-span-2">
                                <p class="text-xl lg:text-3xl font-bold text-center lg:w-1/2">{{ $leader->name }}</p>
                                <p class="text-xl lg:text-3xl font-bold text-center lg:w-1/2">{{ $leader->points }}</p>
                            </div>
                        </a>
                        <div class="pb-5">
                            <div class="border-t border-gray-300"></div>
                        </div>
                    @elseif ($loop->iteration==3)
                        <a class="grid grid-cols-3 gap-2 mx-auto mb-4" href="{{ route('user.profile', $leader->username) }}">
                            <p class="fas fa-medal text-xl lg:text-xl text-amber-700 m-auto"></p>
                            <div class="flex flex-col lg:flex-row col-span-2">
                                <p class="text-lg lg:text-xl font-bold text-center lg:w-1/2">{{ $leader->name }}</p>
                                <p class="text-lg lg:text-xl font-bold text-center lg:w-1/2">{{ $leader->points }}</p>
                            </div>
                        </a>
                        <div class="pb-5">
                            <div class="border-t border-gray-300"></div>
                        </div>
                    @else
                        <a class="grid grid-cols-3 gap-2 mx-auto mb-4" href="{{ route('user.profile', $leader->username) }}">
                            <p class="font-bold text-center">{{ $loop->iteration }}</p>
                            <div class="flex flex-col lg:flex-row col-span-2">
                                <p class="font-bold text-center lg:w-1/2">{{ $leader->name }}</p>
                                <p class="font-bold text-center lg:w-1/2">{{ $leader->points }}</p>
                            </div>
                        </a>
                        <div class="pb-5">
                            <div class="border-t border-gray-300"></div>
                        </div>
                    @endif
                @empty
                    <p class="text-5xl lg:text-9xl text-red-500 text-center my-5">
                        <i class="fas fa-user-times"></i>
                    </p>
                    <p class="text-xl font-bold text-center">Sayang sekali, belum ada peringkat untuk hari ini :(</p>
                @endforelse
            </x-card.base>
        </div>
        <div class="col-span-4 lg:col-span-1">
            @if (!empty($leaderboard))
                <x-card.base>
                    @if ($userRank!==false)
                        Kamu saat ini merupakan peringkat <span class="font-bold">{{ $userRank+1 }}</span>
                    @else
                        Kamu belum termasuk ke dalam 100 besar :(
                    @endif
                </x-card.base>
            @endif
        </div>
    </div>
</div>
