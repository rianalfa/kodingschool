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

        @if (!empty($matter->benchmarks()->get()))
            <div class="mt-4">
                <x-input.label value="Benchmark" />
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full lg:w-1/2">
                    <table class="w-full text-sm text-left text-gray-800">
                        <thead class="text-sm text-gray-800 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Keyword
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jumlah
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matter->benchmarks()->get() as $key => $benchmark)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        {{ $key+1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $benchmark->keyword }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $benchmark->number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-badge.error class="mx-auto cursor-pointer hover:scale-110 active:scale-95 transition-all"
                                            wire:click="deleteBenchmark('{{ $benchmark->id }}')">hapus</x-badge.error>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.black wire:click="$emit('openModal', 'matter.modal-benchmark', {{ json_encode(['matterId' => $matter->id]) }})">+ Benchmark</x-button.black>
        <x-button.primary id="saveInsctruction" class="ml-2">Simpan</x-button.primary>
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
