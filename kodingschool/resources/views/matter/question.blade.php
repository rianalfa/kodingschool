<div class="bg-black text-white h-full overflow-y-auto p-5">
    <x-input.textarea class="bg-black h-full border-none focus:border-none focus:ring-0" wire:model="question">
        {{ $matter->question }}
    </x-input.textarea>
</div>
