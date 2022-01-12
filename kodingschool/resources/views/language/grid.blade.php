<div class="grid grid-cols-3 gap-2">
    <div class="col-span-2">
        <p class="text-3xl text-bold text-gray-800 font-bold text-center">Bahasa</p>
        <x-separator />

        <div class="grid grid-cols-4 gap-3">
            @foreach ($languages as $language)
                <x-anchor.white href="{{ route('study.language', $language->id) }}"
                    class="transition ease-out delay-100 hover:bg-white hover:-translate-y-1 hover:scale-105 duration-200" >
                    <p class="text-lg font-bold text-center">{{ $language->name }}</p>
                    <img src="{{ asset('images/nodejs.png') }}" class="my-3" style="object-fit: scale-down" />
                </x-anchor.white>
            @endforeach
        </div>
    </div>
</div>
