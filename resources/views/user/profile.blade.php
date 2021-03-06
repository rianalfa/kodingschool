<div class="w-full mx-auto">
    <p class="text-3xl text-bold text-gray-800 font-bold text-center">Profil</p>
    <x-separator />

    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-4 lg:col-span-3">
            <x-card.base title="Detail">
                <div class="grid grid-cols-4 gap-4">
                    <div class="flex flex-col content-center justify-center py-8 col-span-4 lg:col-span-1">
                        <img class="rounded-full object-cover border-2 border-gray-300 w-32 h-32 mx-auto" src="{{ user->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                        <p class="text-lg font-bold text-center mt-4 mb-0">{{ '@'.$user->username }}</p>
                        <x-badge.primary class="ml-auto mr-auto px-6 md:px-8">Lvl. {{ $user->detail->level->id }}</x-badge.primary>
                    </div>
                    <div class="col-span-4 lg:col-span-3 pb-4">
                        <div class="grid grid-cols-8 gap-2">
                            <p class="col-span-8 lg:col-span-1 font-bold mt-4">Nama</p>
                            <p class="col-span-7 lg:mt-4">: {{ $user->name }}</p>

                            <p class="col-span-8 lg:col-span-1 font-bold mt-2">Email</p>
                            <p class="col-span-7 lg:mt-2">: {{ $user->email }}</p>

                            <p class="col-span-8 lg:col-span-1 font-bold mt-2">Tingkat</p>
                            @php
                                switch ($user->detail->year) {
                                    case 1: $tingkat='I'; break;
                                    case 2: $tingkat='II'; break;
                                    case 3: $tingkat='III'; break;
                                    case 4: $tingkat='IV'; break;
                                }
                            @endphp
                            <p class="col-span-7 lg:mt-2">: {{ $tingkat ?? '-' }}</p>

                            <p class="col-span-8 lg:col-span-1 font-bold mt-2">Kelas</p>
                            <p class="col-span-7 lg:mt-2">: {{ $user->detail->class ?? '-' }}</p>

                            <p class="col-span-8 lg:col-span-1 font-bold mt-2">Alamat</p>
                            <p class="col-span-7 lg:mt-2">: {{ $user->detail->address ?? '-' }}</p>

                            <p class="col-span-8 lg:col-span-1 font-bold mt-2">No. HP</p>
                            <x-anchor.base href="https://wa.me/{{ $user->detail->phone }}" class="col-span-7 lg:mt-2">: {{ $user->detail->phone ?? '-' }}</x-anchor.base>

                            <p class="col-span-8 text-center italic mt-4">"{{ $user->detail->motto ?? '-' }}"</p>
                        </div>
                    </div>
                </div>
            </x-card.base>
        </div>
        <div class="col-span-4 lg:col-span-1">
            <x-card.base title="Badge">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-2 gap-4">
                    @forelse ($badges as $badge)
                        <div class="py-4">
                            <div class="flex justify-center w-full">
                                {!! $badge->badge->icon !!}
                            </div>
                            <x-badge.black class="text-center w-full mt-2">{{ $badge->badge->name }}</x-badge.black>
                        </div>
                    @empty
                        <p class="text-center">Belum ada badge.</p>
                    @endforelse
                </div>
            </x-card.base>
        </div>
    </div>


    <p class="text-3xl text-bold text-gray-800 font-bold text-center mt-8">Progress</p>
    <x-separator />

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 px-2">
        @forelse ($languages as $language)
            @if ($language->completed!=0)
                <x-study.language :language="$language" />
            @endif
        @empty
            -
        @endforelse
    </div>
</div>
