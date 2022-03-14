<x-app-layout>
    <div class="grid grid-cols-3 gap-2">
        @if (auth()->user()->hasRole('user'))
            <div class="col-span-2">
                @livewire('language.grid')
            </div>
            <div>
                @livewire('planner')
            </div>
        @else
            <div class="col-span-3">
                @livewire('language.grid')
            </div>
        @endif
    </div>
</x-app-layout>
