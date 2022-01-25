<div class="bg-sky-100 p-5">
    <p class="text-sm text-gray-400 mb-0">{{ $matter->chapter()->first()->name }}</p>
    <p class="text-sky-700 font-bold text-2xl mb-3">{{ $matter->name }}</p>

    @foreach ($matter->matter as $m)
        @if (in_array($m, $matter->code))
            <x-card.base class="font-mono border-t-4 border-sky-500">{{ $m }}</x-card.base>
        @else
            <p class="text-justify">
                {{ $m }}
            </p>
        @endif
    @endforeach

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
