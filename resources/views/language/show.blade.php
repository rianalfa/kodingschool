<div class="grid grid-cols-3 gap-x-4 relative">
    <div class="col-span-3">
        <p class="text-3xl text-bold text-gray-800 font-bold text-center pb-2">{{ $language->name }}</p>
        <x-separator />
    </div>

    <div class="col-span-3 lg:col-span-2 max-h-80 lg:max-h-full overflow-y-auto lg:overflow-y-visible">
        @forelse ($chapters as $chapter)
            @php
                $matters = $chapter->matters();
                $count = 0;
                if ($matters->count()!=0) {
                    foreach ($matters->get() as $matter) {
                        if (!empty($matter->study(auth()->user()->id))) $count++;
                    }
                    $progress = $matters->count()!=0 ? floor($count/$matters->count()*100) : 0;
                } else {
                    $progress = 0;
                }
            @endphp
            <x-card.base class="mb-8">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-3 lg:col-span-1">
                        <div class="flex flex-col items-center justify-center bg-sky-100 rounded py-8">
                            <img src="{{ asset('storage/images/languages/'.$chapter->language->id.'.png') }}" class="w-1/2 object-contain"
                                onerror="this.src='{{ asset('images/KS.png') }}'">
                            <p class="text-sky-500 font-bold mt-4">Progress</p>
                            <div class="bg-gray-200 rounded-full w-1/2">
                                @if (!empty($progress))
                                    <div class="bg-sky-500 text-sm text-white text-center align-middle p-0.5 leading-none rounded-full" style="width: {{ $progress }}%"> {{ $progress }}%</div>
                                @else
                                    <div class="text-sm text-white align-middle leading-none rounded-full w-full px-2 py-0.5"> 0%</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3 lg:col-span-2">
                        <div class="flex flex-col justify-around h-full px-4">
                            <div class="flex content-center justify-between w-full">
                                <div class="flex flex-col lg:flex-row w-full">
                                    <p class="text-xl font-bold self-center lg:border-r-2 lg:pr-4">{{ $chapter->name }}</p>
                                    <p class="self-center lg:pl-4">Jumlah Materi: {{ $chapter->matters()->count() }}</p>
                                </div>

                                @if(auth()->user()->hasRole('admin'))
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
                                @endif
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
                                            @php
                                                $latestStudy = \app\Models\Matter::join('studies', 'matters.id', '=', 'studies.matter_id')
                                                                                ->where('chapter_id', $chapter->id)
                                                                                ->where('user_id', auth()->user()->id)
                                                                                ->orderBy('number', 'desc')
                                                                                ->first();
                                            @endphp
                                            <x-anchor.primary class="ml-2"
                                                href="{{ route('study.matter', $latestStudy->matter_id) }}">Lanjutkan Pelajaran</x-anchor.primary>
                                        @endif
                                    @else
                                        <x-anchor.primary class="ml-2"
                                            href="{{ route('study.matter', $matters->orderBy('number', 'asc')->first()->id) }}">Mulai Pelajaran</x-anchor.primary>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-card.base>
        @empty
            <x-card.base>
                <p class="text-xl font-bold text-center w-full mx-auto">Maaf, belum ada bab yang tersedia pada bahasa ini!</p>
            </x-card.base>
        @endforelse
    </div>

	<div class="col-span-3 lg:col-span-1">
    	@if ($activeChapter!=null)
        	@livewire('chapter.show', ['chapterId' => $activeChapter])
    	@endif
	</div>

    @if (!auth()->user()->hasRole('user'))
        <div class="fixed bottom-10 right-10">
            <x-button.primary class="text-2xl md:text-4xl lg:text-6xl rounded-full"
                wire:click="$emit('openModal', 'chapter.modal-chapter', {{ json_encode([
                            'language' => $language->id
                        ]) }})">
                <i class="fas fa-plus"></i>
            </x-button.primary>
        </div>
    @endif
</div>
