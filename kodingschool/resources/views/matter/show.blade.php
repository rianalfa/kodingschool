<div class="flex relative h-full pb-12">
    <div class="grid grid-cols-{{ !empty($matter->instruction) ? '3' : '2' }} gap-0 w-full">
        <div class="bg-sky-100 h-full overflow-y-auto p-6
            scrollbar-thin scrollbar-track-gray-200 scrollbar-thumb-gray-400 hover:scrollbar-thumb-gray-500">

            <p class="text-sm text-gray-400 mb-0">{{ $matter->chapter()->first()->name }}</p>
            <p class="text-sky-700 font-bold text-2xl mb-3">{{ $matter->name }}</p>

            @forelse ($matter->matter as $m)
                @if (in_array($m, $matter->code))
                    <x-card.base class="font-mono border-t-4 border-sky-500">{{ $m }}</x-card.base>
                @else
                    <p class="text-justify">
                        {{ $m }}
                    </p>
                @endif
            @empty
                -
            @endforelse

            @if (!empty($matter->instruction))
                <div class="w-full mt-5">
                    <div class="w-full bg-gray-300 rounded-t-lg py-2 px-4">
                        <p class="text-gray-800 text-lg font-bold">Instruksi</p>
                    </div>
                    <div class="w-full bg-white border-x-2 border-b-2 border-gray-300 rounded-b-lg py-2 px-2">
                        @foreach ($matter->instruction as $i)
                            @if (in_array($i, $matter->codeInstruction))
                                <x-card.base class="font-mono border-t-4 border-sky-500">
                                    {{ $i }}
                                </x-card.base>
                            @else
                                <p class="text-justify px-4">
                                    {{ $i }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if (!empty($matter->instruction))
            <div class="h-full overflow-y-hidden">
                <x-input.textarea class="bg-gray-900 text-white font-mono rounded-none resize-none w-full h-full overflow-y-auto mt-0 p-6
                    scrollbar-thin scrollbar-track-gray-200 scrollbar-thumb-gray-400 hover:scrollbar-thumb-gray-500" wire:model.defer="question">
                    {{ $matter->question }}
                </x-input.textarea>
            </div>
        @endif

        @livewire('matter.shell', ['text' => ''])
    </div>

    <div class="bg-sky-700 absolute bottom-0 left-0 w-full h-12 px-6">
        <div class="grid grid-cols-3 gap-0 w-full h-full">
            <div class="flex items-center">
                <p class="text-white font-bold mb-0">
                    {{ auth()->user()->username }}
                </p>
            </div>
            <div class="flex items-center">
                <div class="grid grid-cols-6 gap-0 w-full items-center">
                    <div class="text-white font-bold mb-0">
                        Level {{ auth()->user()->detail()->first()->level()->first()->id }}
                    </div>
                    <div class="col-span-5 bg-gray-200 rounded-lg h-4">
                        <div class="bg-sky-500 rounded-lg h-4" style="width: {{ $nextLevel }}%"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div x-data="{ open: false }" class="relative">
                    <ul x-show="open" @click.away="open = false" class="bg-white rounded absolute bottom-6 right-0 w-48 p-2">
                        <li><p class="text-sm">Apakah Anda yakin ingin melihat hint jawaban?</p></li>
                        <li class="flex justify-end mt-2"><x-button.warning class="text-sm ml-auto py-0"
                            wire:click="$emit('openModal', 'matter.modal-hint', {{ json_encode(['hint' => $matter->hint]) }})">
                            Yakin
                        </x-button.warning></li>
                    </ul>

                    <x-button.warning @click="open = true" class="py-1">Lihat Hint</x-button.warning>
                </div>
                <x-button.white class="py-1 ml-2" wire:click="next">
                    Next
                </x-button.white>
            </div>
        </div>
    </div>
</div>
