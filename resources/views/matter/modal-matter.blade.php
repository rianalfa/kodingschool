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

        <div class="mt-4" wire:ignore>
            <x-input.label value="Penjelasan Materi" />
            <x-input.editor id="matter"></x-input.editor>
            <x-input.error for="matter.matter" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary id="saveMatter">Simpan</x-button.primary>
    </x-modal.footer>

    <script defer>
        let editor = new Editor({
            el: document.querySelector('#matter'),
            initialEditType: 'wysiwyg',
            plugins: [colorSyntax, codeSyntaxHighlight]
        });
        editor.setHTML(`{!! \Illuminate\Support\Str::markdown($matter->matter) !!}`, true);

        document.getElementById('saveMatter').addEventListener('click', e => {
            window.livewire.emit('saveMatter', editor.getMarkdown());
        });
    </script>
</div>
