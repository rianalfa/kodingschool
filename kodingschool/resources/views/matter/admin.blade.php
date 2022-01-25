<div>
    <x-modal.lg id="modalTambahMatter" title="Materi Baru">
        <x-modal.body>
            <div>
                <x-input.label value="Judul Materi" />
                <x-input.text wire:model.defer="name" required autofocus />
                @error('name') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Nomor Materi" />
                <x-input.text wire:model.defer="number" required />
                @error('number') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Kesulitan Materi" />
                <x-input.select wire:model.defer="difficulty_id">
                    @foreach ($difficulty as $diff)
                        <option value="{{ $diff->id }}">{{ $diff->name }}</option>
                    @endforeach
                </x-input.select>
                @error('difficulty_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Penjelasan Materi" />
                <x-input.textarea wire:model="matter"></x-input.textarea>
                @error('matter') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Instruksi Materi" />
                <x-input.textarea wire:model="instruction"></x-input.textarea>
                @error('instruction') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Jawaban Benar" />
                <x-input.textarea wire:model="answer"></x-input.textarea>
                @error('answer') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Potongan Jawaban" />
                <x-input.textarea wire:model="question"></x-input.textarea>
                @error('question') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Hint Jawaban" />
                <x-input.textarea wire:model="hint"></x-input.textarea>
                @error('hint') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-input.label value="Bab" />
                <x-input.select wire:model.defer="chapter_id">
                    @foreach ($chapters as $chapter)
                        <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                    @endforeach
                </x-input.select>
                @error('chapter_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </x-modal.body>
        <x-modal.footer>
            <x-button.primary wire:click="addNewMatter">Tambah Materi Baru</x-button.primary>
        </x-modal.footer>
    </x-modal.lg>
</div>
