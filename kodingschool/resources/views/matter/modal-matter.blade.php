<div class="overflow-y-auto" style="max-height: 90vh">
    <x-modal.header>Materi</x-modal.header>
    <x-modal.body>
        <div>
            <x-input.label value="Judul Materi" />
            <x-input.text wire:model.defer="matter.name" required autofocus />
            <x-input.error for="matter.name" />
            @error('name') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="mt-4">
            <x-input.label value="Nomor Materi" />
            <x-input.text wire:model.defer="matter.number" required />
            <x-input.error for="matter.number" />
        </div>
        <div class="mt-4">
            <x-input.label value="Kesulitan Materi" />
            <x-input.select wire:model.defer="matter.difficulty_id">
                <option disabled selected hidden></option>
                @foreach ($difficulties as $diff)
                    <option value="{{ $diff->id }}">{{ $diff->name }}</option>
                @endforeach
            </x-input.select>
            <x-input.error for="matter.difficulty_id" />
        </div>
        <div class="mt-4">
            <x-input.label value="Penjelasan Materi" />
            <x-input.textarea wire:model.defer="matter.matter"></x-input.textarea>
            <x-input.error for="matter.matter" />
        </div>
        <div class="mt-4">
            <x-input.label value="Instruksi Materi" />
            <x-input.textarea wire:model.defer="matter.instruction"></x-input.textarea>
            <x-input.error for="matter.instruction" />
        </div>
        <div class="mt-4">
            <x-input.label value="Jawaban Benar" />
            <x-input.textarea wire:model.defer="matter.answer"></x-input.textarea>
            <x-input.error for="matter.answer" />
        </div>
        <div class="mt-4">
            <x-input.label value="Potongan Jawaban" />
            <x-input.textarea wire:model.defer="matter.question"></x-input.textarea>
            <x-input.error for="matter.question" />
        </div>
        <div class="mt-4">
            <x-input.label value="Hint Jawaban" />
            <x-input.textarea wire:model.defer="matter.hint"></x-input.textarea>
            <x-input.error for="matter.hint" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary wire:click="addNewMatter">Simpan</x-button.primary>
        <x-button.black class="ml-2" wire:click="checkAnswer()">cek</x-button.black>
    </x-modal.footer>
</div>
