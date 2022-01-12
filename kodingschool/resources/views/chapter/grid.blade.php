<div>
    @foreach ($chapters as $chapter)
        <x-button.primary class="hover:bg-sky-500 text-lg text-left relative w-full my-2" disabled>
            <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-sky-700 rounded">
                <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-gray-100"></span>
            </span>
            <span class="relative w-full text-left text-white">{{ $chapter->name }}</span>
        </x-button.primary>

        @livewire('matter.grid', ['chapter' => $chapter->id])
        <x-separator />
    @endforeach
</div>
