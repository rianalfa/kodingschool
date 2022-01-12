<div class="grid grid-cols-3">
    <div class="col-span-2">
        <p class="text-3xl text-bold text-gray-800 font-bold text-center">{{ $language->name }}</p>
        <x-separator />

        @livewire('chapter.grid', ['language' => $language])
    </div>
    <div></div>
</div>
