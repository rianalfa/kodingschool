<div>
    @foreach ($chapters as $chapter)
        <x-button.primary class="text-lg text-left w-full my-2 border-b-4 border-sky-700 hover:border-sky-500 active:border-none active:mt-3 focus:border-sky-700"
            wire:click="show({{ $chapter->id }})">
            {{ $chapter->name }}
        </x-button.primary>

        @if ($ch == $chapter->id && $show == true)
            @livewire('matter.grid', ['chapter' => $chapter->id])
            <x-separator />
        @endif
    @endforeach
</div>
