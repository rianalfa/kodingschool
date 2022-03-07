<div class="h-full overflow-y-hidden">
    <p class="font-bold bg-gray-100 border-2 border-b-0 border-black rounded-t px-3 py-2 mb-0">Shell</p>
    <x-input.textarea class="bg-gray-900 text-white text-sm font-mono rounded-none resize-none w-full h-full overflow-y-auto mt-0 p-4
        scrollbar-thin scrollbar-track-gray-200 scrollbar-thumb-gray-400 hover:scrollbar-thumb-gray-500"
        wire:model.defer="text" wire:keydown.enter="shellExec">
        {{ $text }}
    </x-input.textarea>
</div>
