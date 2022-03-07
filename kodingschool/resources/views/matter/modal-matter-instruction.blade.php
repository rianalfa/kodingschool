<div class="overflow-y-auto" style="max-height: 90vh">
    <x-modal.header>Materi</x-modal.header>
    <x-modal.body>
        <div wire:ignore>
            <x-input.label value="Instruksi Materi" />
            <x-input.editor id="instructionEditor"></x-input.editor>
            <x-input.error for="matter.instruction" />
        </div>

        <div class="mt-4">
            <x-input.label value="Jawaban Benar" />
            <x-input.file wire:model.defer="answer" />
            <x-input.error for="answer" />
        </div>

        <div class="mt-4" wire:ignore>
            <x-input.label value="Potongan Jawaban" />
            <x-input.textarea id="code" style="height: 300px;" wire:model.defer="matter.question"></x-input.textarea>
            <x-input.error for="matter.question" />
        </div>

        <div class="mt-4">
            <x-input.label value="Hint Jawaban" />
            <x-input.textarea wire:model.defer="matter.hint"></x-input.textarea>
            <x-input.error for="matter.hint" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary id="saveInsctruction">Simpan</x-button.primary>
    </x-modal.footer>

    <script defer>
        let editor;
        let codeEditor;

        editor = new Editor({
            el: document.querySelector('#instructionEditor'),
            initialEditType: 'wysiwyg',
            plugins: [colorSyntax, codeSyntaxHighlight]
        });
        editor.setHTML(`{!! \Illuminate\Support\Str::markdown($matter->instruction) !!}`, true);

        codeEditor = CodeMirror.fromTextArea(document.getElementById("code"), {
            theme: 'dracula',
            matchBrackets: true,
            mode: "{{ $matter->chapter->language->mode }}",
            indentUnit: 4,
            smartIndent: true,
            indentWithTabs: true,
            cursorHeight: 0.85,
        });

        document.getElementById('saveInsctruction').addEventListener('click', e => {
            window.livewire.emit('saveInsctruction', editor.getMarkdown(), codeEditor.getValue());
        });
    </script>
</div>
