<div class="flex h-full overflow-y-auto">
    <div class="flex flex-col flex-1 overflow-y-auto mb-6 pb-6">
        @if (!empty($matter->instruction))
        <div class="grid grid-cols-3 gap-0">
        @else
        <div class="grid grid-cols-2 gap-0">
        @endif
            @livewire('matter.detail', ['matter' => $matter])

            @if (!empty($matter->instruction))
                @livewire('matter.question', ['matter' => $matter])
            @endif
        </div>
    </div>
</div>
