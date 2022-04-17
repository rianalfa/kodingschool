<div class="overflow-y-auto" style="max-height: 90vh">
    <x-modal.header>Benchmark</x-modal.header>
    <x-modal.body>
        <div>
            <x-input.label value="Keyword" />
            <x-input.text wire:model.defer="benchmark.keyword" />
            <x-input.error for="benchmark.keyword" />
        </div>

        <div>
            <x-input.label value="Jumlah" />
            <x-input.text wire:model.defer="benchmark.number" />
            <x-input.error for="benchmark.number" />
        </div>
    </x-modal.body>
    <x-modal.footer class="justify-end">
        <x-button.primary wire:click="saveBenchmark">Simpan</x-button.primary>
    </x-modal.footer>
</div>
