
<div class="flex flex-col flex-1 overflow-x-hidden mb-6 pb-6">
    @if (!empty($matter->instruction))
    <div class="grid grid-cols-3 gap-0">
    @else
    <div class="grid grid-cols-2 gap-0">
    @endif
        <div>
            @livewire('matter.detail', ['matter' => $matter])
        </div>

        @if (!empty($matter->instruction))
            @livewire('matter.question', ['matter' => $matter])

            <div>
                {{ $matter->name }}
            </div>
        @endif
    </div>
</div>
