<div
    {{ $attributes->merge(['class' => "flex justify-between items-center rounded-t px-5 pt-5"]) }}
    >
    <p class="text-lg font-bold text-gray-900 lg:text-xl dark:text-white">
        {{ $slot }}
    </p>
    <x-button.white class="hover:bg-white text-xl text-gray-400 hover:text-gray-700 border-none hover:border-none py-1 px-1" wire:click="closeModal('modal1')">
        <i class="fas fa-times h-full"></i>
    </x-button.white>
</div>
