<div>
    @foreach ($chapters as $chapter)
        <div class="bg-sky-700 text-white text-lg text-left font-bold rounded-md relative w-full my-2 py-2 px-4">
            <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-sky-500 rounded">
                <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-gray-100"></span>
            </span>
            <span class="relative w-full text-left text-white">{{ $chapter->name }}</span>
        </div>

        @livewire('matter.grid', ['chapter' => $chapter->id])
        <x-separator />
    @endforeach
</div>
