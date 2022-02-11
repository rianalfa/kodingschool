<div>
    @foreach ($matters as $matter)
        @if (!empty($matter->study(auth()->user()->id)))
            <div class="flex">
                <x-anchor.white class="text-left inline-block mb-2 mr-2 border-b-4 border-b-sky-500 {{ auth()->user()->hasRole('user') ? 'w-full' : 'w-10/12' }}
                    hover:bg-white hover:border-b-sky-700 active:bg-white active:border-b-white active:translate-y-1 transition ease-in-out duration-75 focus:border-b-sky-700"
                    href="{{ route('study.matter', $matter) }}" >
                    <div class="grid grid-cols-2">
                        <div>
                            {{ $matter->name }}
                        </div>
                        <div class="flex justify-end">
                            <x-badge.primary>{{ $matter->difficulty()->first()->name }}</x-badge.primary>
                        </div>
                    </div>
                </x-anchor.white>
                @role('admin')
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <x-button.white class="float-right btn-dropdown"><i class="fas fa-ellipsis-v text-sm"></i></x-button.white>
                        </x-slot>

                        <x-slot name="content">
                            <x-button.white class="text-left border-0 w-full btn-dropdown"
                                wire:click="$emit('openModal', 'matter.modal-matter', {{ json_encode([
                                    'chapter' => $chapterId,
                                    'id' => $matter->id,
                                    ]) }})">
                                Edit
                            </x-button.white>
                            <x-button.white class="text-red-500 text-left border-0 w-full btn-dropdown"
                                wire:click="$emit('openModal', 'matter.modal-delete', {{ json_encode([
                                    'chapter' => $chapterId,
                                    'id' => $matter->id,
                                    ]) }})">
                                Delete
                            </x-button.white>
                        </x-slot>
                    </x-jet-dropdown>
                @endrole
            </div>
        @else
            <div class="flex">
                <x-anchor.black class="text-left inline-block mb-2 mr-2 border-b-4 border-b-gray-500 {{ auth()->user()->hasRole('user') ? 'w-full' : 'w-10/12' }}
                    hover:border-b-gray-400 hover:bg-gray-700 active:bg-gray-700 active:border-b-gray-700 active:translate-y-1 transition ease-in-out duration-75 focus:border-b-gray-400"
                    wire:click="matterNotAvailable" >
                    <div class="grid grid-cols-2">
                        <div>
                            {{ $matter->name }}
                        </div>
                        <div class="flex justify-end">
                            <x-badge.secondary>{{ $matter->difficulty()->first()->name }}</x-badge.secondary>
                        </div>
                    </div>
                </x-anchor.black>
                @role('admin')
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <x-button.white class="float-right btn-dropdown"><i class="fas fa-ellipsis-v text-sm"></i></x-button.white>
                        </x-slot>

                        <x-slot name="content">
                            <x-button.white class="text-left border-0 w-full btn-dropdown"
                                wire:click="$emit('openModal', 'matter.modal-matter', {{ json_encode([
                                    'chapter' => $chapterId,
                                    'id' => $matter->id,
                                    ]) }})">
                                Edit
                            </x-button.white>
                            <x-button.white class="text-red-500 text-left border-0 w-full btn-dropdown"
                                wire:click="$emit('openModal', 'matter.modal-delete', {{ json_encode([
                                    'chapter' => $chapterId,
                                    'id' => $matter->id,
                                    ]) }})">
                                Delete
                            </x-button.white>
                        </x-slot>
                    </x-jet-dropdown>
                @endrole
            </div>
        @endif
    @endforeach

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.btn-dropdown').click(function(e) {
                e.preventDefault();
            });
        });
    </script>
</div>
