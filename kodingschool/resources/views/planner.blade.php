<div class="px-5">
    <p class="text-lg text-bold text-gray-800 font-bold text-center mt-5 mx-2">Rencana Belajar</p>

    <div class="flex justify-center mt-3 mb-5 mx-2">
        @foreach ($days as $day)
            @php
                switch ($planner[$day]) {
                    case '1':
                        $class = "border-b-yellow-500 hover:bg-white active:border-b-yellow-500 focus:border-b-yellow-500";
                        break;
                    case '2':
                        $class = "border-b-red-500 hover:bg-white active:border-b-red-500 focus:border-b-red-500";
                        break;
                    case '3':
                        $class = "border-b-green-500 hover:bg-white active:border-b-green-500 focus:border-b-green-500";
                        break;
                    default:
                        $class = "hover:bg-white border-b-gray-400 focus:border-b-gray-400";
                }
            @endphp

            @if ($disabled==true)
                <x-button.white class="text-lg font-bold uppercase border-b-4 mx-0.5 {{ $class }}" wire:click="setPlanner('{{ $day }}')" disabled>
                    {{substr($day,0,1)}}
                </x-button.white>
            @else
                <x-button.white class="text-lg hover:scale-125 font-bold uppercase border-b-4 mx-0.5 {{ $class }}" wire:click="setPlanner('{{ $day }}')">
                    {{substr($day,0,1)}}
                </x-button.white>
            @endif
        @endforeach
    </div>

    @if ($disabled)
        <div class="flex justify-start w-full mb-7">
            <x-button.primary class="text-xs" wire:click="editPlanner">Atur Rencana Belajar</x-button.primary>
        </div>
    @else
        <div class="flex justify-end w-full mb-7">
            <x-button.primary class="text-xs" wire:click="editPlanner">Simpan</x-button.primary>
        </div>
    @endif

    <x-card.base title="Catatan">
        <x-input.textarea rows="10" wire:model.defer="note" wire:keydown.escape="editNote"></x-input.textarea>
        <p class="text-gray-400 text-xs italic mt-3 mb-0">*Tekan tombol escape pada keyboard setelah mengubah catatan</p>
    </x-card.base>
</div>
