<div class="relative px-3">
    <p class="text-3xl text-bold text-gray-800 font-bold text-center">Bahasa</p>
    <x-separator />

    <div class="grid grid-cols-4 gap-3">
        @foreach ($languages as $language)
            <x-anchor.white href="{{ route('study.language', $language->id) }}"
                class="transition ease-out delay-100 hover:bg-white hover:-translate-y-1 hover:scale-105 duration-200" >
                <p class="text-lg lg:text-xl font-bold text-center">{{ $language->name }}</p>
                <img src="{{ asset('images/nodejs.png') }}" class="object-scale-down mx-auto my-3 lg:w-4/5" />
            </x-anchor.white>
        @endforeach
    </div>

    @role('admin')
        @livewire('language.admin')
    @endrole
</div>
