<div class="bg-black text-white h-full overflow-y-hidden">
    <x-input.textarea class="bg-black font-mono h-full border-none focus:border-none focus:ring-0 p-5" wire:model.defer="question">
        {{ $matter->question }}
    </x-input.textarea>
</div>
