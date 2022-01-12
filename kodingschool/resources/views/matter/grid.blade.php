<div class="ml-5 mb-4 pl-5">
    @foreach ($matters as $matter)
        @if (in_array($matter->id, $availableMatter))
            <x-anchor.white class="text-left font-bold block mb-2 border-b-4 border-b-sky-700 hover:bg-white hover:border-b-sky-500 active:bg-white active:border-b-white focus:border-b-sky-700"
                href="{{ route('matter.show', ['matter' => $matter]) }}" >
                <div class="grid grid-cols-2">
                    <div>
                        {{ $matter->name }}
                    </div>
                    <div class="flex justify-end">
                        <x-badge.primary>{{ $matter->difficulty()->first()->name }}</x-badge.primary>
                    </div>
                </div>
            </x-anchor.white>
        @else
            <x-button.black class="text-left block w-full mb-2 border-b-4 border-b-gray-500 hover:border-b-gray-400 active:border-b-gray-700focus:border-b-gray-400"
                wire:click="matterNotAvailable" >
                <div class="grid grid-cols-2">
                    <div>
                        {{ $matter->name }}
                    </div>
                    <div class="flex justify-end">
                        <x-badge.secondary>{{ $matter->difficulty()->first()->name }}</x-badge.secondary>
                    </div>
                </div>
            </x-button.black>
        @endif
    @endforeach
</div>
