<div class="bg-sky-800 fixed bottom-0 left-0 w-full h-12 px-6">
    <div class="grid grid-cols-3 gap-0 w-full h-full">
        <div class="flex items-center">
            <p class="text-white font-bold mb-0">
                {{ Auth::user()->name }}
            </p>
        </div>
        <div class="flex items-center">
            <div class="grid grid-cols-6 gap-0 w-full items-center">
                <div class="text-white font-bold mb-0">
                    Level {{ $level->id }}
                </div>
                <div class="col-span-5 bg-gray-200 rounded-lg h-5">
                    <div class="bg-sky-500 rounded-lg h-5" style="width: {{ $nextLevel }}%"></div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end">
            <x-button.primary class="py-1" wire:click="next">
                Next
            </x-button.primary>
        </div>
    </div>
</div>
