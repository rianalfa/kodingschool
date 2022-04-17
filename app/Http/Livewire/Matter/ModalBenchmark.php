<?php

namespace App\Http\Livewire\Matter;

use App\Models\Benchmark;
use Exception;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalBenchmark extends ModalComponent
{
    public $matterId;
    public $benchmark;

    protected $rules = [
        'benchmark.keyword' => 'filled|string|max:50',
        'benchmark.number' => 'filled|numeric|min:1',
    ];

    public function mount($matterId) {
        $this->matterId = $matterId;
        $this->benchmark = new Benchmark();
    }

    public function saveBenchmark() {
        if (auth()->user()->hasRole('admin')) {
            $this->benchmark->matter_id = $this->matterId;
            $this->validate();

            try {
                $this->benchmark->save();
                $this->emit('success', 'Benchmark berhasil disimpan');
                $this->emit('reloadModalInstruction');
            } catch (Exception $e) {
                $this->emit('error', 'Benchmark gagal disimpan');
            }
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('matter.modal-benchmark');
    }
}
