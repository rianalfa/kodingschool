<div class="mb-4 pl-5">
    @foreach ($matters as $matter)
        <x-anchor.white class="text-left block w-full mb-2"
            href="{{ ($matter->number <= $availableMatter) ? route('matter.show', $matter->id) : '#' }}" >
            <div class="grid grid-cols-2">
                <div>
                    {{ $matter->name }}
                </div>
                <div>
                    <p class="text-sky-700 text-right mb-0">{{ $matter->difficulty()->first()->name }}</p>
                </div>
            </div>
        </x-anchor.white>
    @endforeach
</div>
