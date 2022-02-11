<div class="grid grid-cols-3 gap-x-4 relative">
    <div class="col-span-3">
        <p class="text-3xl text-bold text-gray-800 font-bold text-center pb-2">{{ $language->name }}</p>
        <x-separator />
    </div>

    <div class="col-span-2">
        @foreach ($chapters as $chapter)
            @php
                $matters = $chapter->matters();
                $count = 0;
                if ($matters->count()!=0) {
                    foreach ($matters->get() as $matter) {
                        if (!empty($matter->study(auth()->user()->id))) $count++;
                    }
                    $progress = $matters->count()!=0 ? floor($count/$matters->count()*100) : 0;
                }
            @endphp
            <x-card.base class="mb-8">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <div class="flex flex-col items-center justify-center bg-sky-100 rounded py-8">
                            <img src="{{ asset('images/nodejs.png') }}" class="w-1/2 object-contain">
                            <p class="text-sky-500 font-bold mt-4">Progress</p>
                            <div class="bg-gray-200 rounded-full w-1/2">
                                @if ($progress!=0)
                                    <div class="bg-sky-500 text-sm text-white text-center align-middle p-0.5 leading-none rounded-full" style="width: {{ $progress }}%"> {{ $progress }}%</div>
                                @else
                                    <div class="text-sm text-white align-middle leading-none rounded-full w-full px-2 py-0.5"> {{ $progress }}%</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="flex flex-col justify-around h-full px-4">
                            <div class="flex content-center justify-between w-full">
                                <div class="flex">
                                    <p class="text-xl font-bold self-center border-r-2 pr-4">{{ $chapter->name }}</p>
                                    <p class="self-center pl-4">Jumlah Materi: {{ $chapter->matters()->count() }}</p>
                                </div>

                                @role('admin')
                                    <x-jet-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <x-button.white class="float-right btn-dropdown"><i class="fas fa-ellipsis-v"></i></x-button.white>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-button.white class="text-left border-0 w-full btn-dropdown"
                                                wire:click="$emit('openModal', 'chapter.modal-chapter', {{ json_encode([
                                                    'language' => $language->id, 'id' => $chapter->id,
                                                ]) }})">
                                                Edit
                                            </x-button.white>
                                            <x-button.white class="text-red-500 text-left border-0 w-full btn-dropdown"
                                                wire:click="$emit('openModal', 'chapter.modal-delete', {{ json_encode(['id' => $chapter->id]) }})">
                                                Delete
                                            </x-button.white>
                                        </x-slot>
                                    </x-jet-dropdown>
                                @endrole
                            </div>
                            <p class="text-clip overflow-hidden w-full h-1/3">{{ $chapter->description }}</p>

                            <div class="flex justify-end">
                                <x-button.white wire:click="checkDetail('{{ $chapter->id }}')">Lihat Detail</x-button.white>

                                @if ($matters->count()!=0)
                                    @if (!empty($matters->first()->study(auth()->user()->id)))
                                        @if ($count == $matters->count())
                                            <x-anchor.white class="text-sky-500 border-sky-500 ml-2"
                                                href="{{ route('study.matter', $matters->first()->id) }}">Lihat Kembali</x-anchor.white>
                                        @else
                                            <x-anchor.primary class="ml-2"
                                                href="{{ route('study.matter', $matters->orderBy('id', 'desc')->first()->id) }}">Lanjutkan Pelajaran</x-anchor.primary>
                                        @endif
                                    @else
                                        <x-anchor.primary class="ml-2"
                                            href="{{ route('study.matter', $matters->first()->id) }}">Mulai Pelajaran</x-anchor.primary>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-card.base>
        @endforeach
    </div>

    @if ($activeChapter!=null)
        @livewire('chapter.show', ['chapterId' => $activeChapter])
    @endif
</div>
