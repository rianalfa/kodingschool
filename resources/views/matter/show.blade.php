<div class="flex relative h-max lg:h-full pb-12">
    <div class="grid grid-cols-{{ !empty($matter->instruction) ? '3' : '2' }} gap-0 w-full">
        <div class="col-span-3 lg:col-span-1 bg-sky-100 h-80 lg:h-full overflow-y-auto py-6
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
            <div class="col-span-3 lg:col-span-1 h-80 lg:h-full overflow-y-hidden" wire:ignore>
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

        <div class="col-span-3 lg:col-span-1 h-80 lg:h-full">
            @if (in_array($matter->chapter->language->type, ['pas', 'cpp', 'java', 'js', 'php']))
                @livewire('matter.shell', ['text' => ''])
            @else
                    @livewire('matter.iframe', ['text' => $question])
            @endif
        </div>
    </div>

    <div class="bg-sky-700 absolute bottom-0 left-0 w-full h-max lg:h-12 px-6 py-2 lg:py-0">
        <div class="grid grid-cols-3 gap-0 w-full h-full">
            <div class="flex items-center col-span-3 lg:col-span-1 my-1 lg:my-0">
                <p class="text-white font-bold mb-0">
                    {{ '@'.auth()->user()->username }}
                </p>
            </div>
            <div class="flex items-center col-span-3 lg:col-span-1 my-1 lg:my-0">
                <div class="grid grid-cols-6 gap-0 w-full items-center">
                    <div class="col-span-2 lg:col-span-1 text-white font-bold mb-0">
                        Level {{ auth()->user()->detail()->first()->level()->first()->id }}
                    </div>
                    <div class="col-span-4 lg:col-span-5 bg-gray-200 rounded-lg h-4">
                        <div class="bg-sky-500 rounded-lg h-4" style="width: {{ $nextLevel }}%"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between lg:justify-end col-span-3 lg:col-span-1 my-1 lg:my-0" wire:ignore>
                <div x-data="{ open: false }" class="relative">
                    <ul x-show="open" @click.away="open = false" class="bg-white rounded absolute bottom-6 left-0 lg:right-0 w-48 p-2">
                        <li><p class="text-sm">Apakah Anda yakin ingin melihat hint jawaban?</p></li>
                        <li class="flex justify-end mt-2"><x-button.warning class="text-sm ml-auto py-0"
                            wire:click="$emit('openModal', 'matter.modal-hint', {{ json_encode(['hint' => $matter->hint]) }})">
                            Yakin
                        </x-button.warning></li>
                    </ul>

                    <x-button.warning @click="open = true" class="py-1">Lihat Hint</x-button.warning>
                </div>

                <x-button.primary class="py-1 ml-2" wire:click="$emit('runScript')">
                    Run Script
                </x-button.primary>

                <x-button.white class="py-1 ml-2" wire:click="$emit('saveCodeEditor')">
                    Next
                </x-button.white>
            </div>
        </div>
    </div>
    <div class="absolute right-4 bottom-16 lg:bottom-14 z-50" wire:loading.delay.long>
        <svg role="status" class="bg-white text-gray-300 font-bold fill-gray-800 rounded-full w-8 h-8 p-0.5 animate-spin" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </div>
</div>
