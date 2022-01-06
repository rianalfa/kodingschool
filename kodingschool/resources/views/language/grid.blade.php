<div class="grid grid-cols-4 gap-3">
    @foreach ($languages as $language)
        <x-anchor.white href="{{ route('language.show', $language->id) }}"
            class="transition ease-out delay-100 hover:-translate-y-1 hover:scale-105 duration-200" >
            <p class="text-lg font-bold text-center">{{ $language->name }}</p>
            <img src="{{ asset('images/nodejs.png') }}" class="my-3" style="object-fit: scale-down" />
        </x-anchor.white>
    @endforeach
</div>
