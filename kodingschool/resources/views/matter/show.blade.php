<div class="flex relative h-full pb-12">
    <div class="grid grid-cols-{{ !empty($matter->instruction) ? '3' : '2' }} gap-0 w-full">
        <div class="bg-sky-100 h-full overflow-y-auto py-6
            scrollbar-thin scrollbar-track-gray-200 scrollbar-thumb-gray-400 hover:scrollbar-thumb-gray-500">

            <p class="text-sm text-gray-400 mb-0 px-6">{{ $matter->chapter()->first()->name }}</p>
            <p class="text-sky-700 font-bold text-2xl mb-3 px-6">{{ $matter->name }}</p>

            @if (!empty($matter->matter))
                <p id="matter" class="px-6" wire:init="initiateViewer" wire:ignore></p>
            @else
                -
            @endif
        </div>

        @if (!empty($matter->instruction))
            <div class="h-full overflow-y-hidden" wire:ignore>
                <x-input.textarea id="code" wire:model.defer="question" wire:init="initiateCodeEditor"></x-input.textarea>
            </div>
        @endif

        @if (auth()->user()->hasRole('ujicoba'))
            <div class="w-full mt-6">
                <div class="bg-gray-300 rounded-t-lg py-2 px-4">
                    <p class="text-gray-800 text-lg font-bold"></p>
                </div>
                <div class="bg-white border-x-2 border-b-2 border-gray-300 rounded-b-lg py-2 px-2">
                    <p class="text-justify px-4"></p>
                </div>
            </div>
        @endif

        @if (in_array($matter->chapter->language->type, ['pas', 'cpp', 'java', 'js', 'php']))
            @livewire('matter.shell', ['text' => ''])
        @else
            @livewire('matter.iframe', ['text' => $question])
        @endif
    </div>

    <div class="bg-sky-700 absolute bottom-0 left-0 w-full h-12 px-6">
        <div class="grid grid-cols-3 gap-0 w-full h-full">
            <div class="flex items-center">
                <p class="text-white font-bold mb-0">
                    {{ auth()->user()->username }}
                </p>
            </div>
            <div class="flex items-center">
                <div class="grid grid-cols-6 gap-0 w-full items-center">
                    <div class="text-white font-bold mb-0">
                        Level {{ auth()->user()->detail()->first()->level()->first()->id }}
                    </div>
                    <div class="col-span-5 bg-gray-200 rounded-lg h-4">
                        <div class="bg-sky-500 rounded-lg h-4" style="width: {{ $nextLevel }}%"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end" wire:ignore>
                <div x-data="{ open: false }" class="relative">
                    <ul x-show="open" @click.away="open = false" class="bg-white rounded absolute bottom-6 right-0 w-48 p-2">
                        <li><p class="text-sm">Apakah Anda yakin ingin melihat hint jawaban?</p></li>
                        <li class="flex justify-end mt-2"><x-button.warning class="text-sm ml-auto py-0"
                            wire:click="$emit('openModal', 'matter.modal-hint', {{ json_encode(['hint' => $matter->hint]) }})">
                            Yakin
                        </x-button.warning></li>
                    </ul>

                    <x-button.warning @click="open = true" class="py-1">Lihat Hint</x-button.warning>
                </div>
                <x-button.white class="py-1 ml-2" wire:click="$emit('saveCodeEditor')">
                    Next
                </x-button.white>
            </div>
        </div>
    </div>
</div>
