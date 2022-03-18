<?php

namespace App\Http\Livewire\Matter;

use App\Http\Controllers\Admin;
use App\Models\Matter;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class ModalMatterInstruction extends ModalComponent
{
    use WithFileUploads;

    public $matter;
    public $answer;

    protected $listeners = [
        'saveInsctruction' => 'saveInsctruction',
        'javaScriptAnswer' => 'javaScriptAnswer',
    ];

    protected function rules() {
        return [
            'matter.instruction' => 'nullable|string',
            'answer' => 'nullable|file|max:20000',
            'matter.question' => 'nullable|string',
            'matter.hint' => 'nullable|string',
        ];
    }

    public function mount($id) {
        $this->matter = Matter::whereId($id)->first() ?? new Matter();
        if ($this->matter->instruction==null) $this->matter->instruction="";
    }

    public function saveInsctruction($instruction, $question) {
        if (auth()->user()->hasRole('admin')) {
            $this->matter->instruction = $instruction;
            $this->matter->question = $question;

            $this->validate();

            if (!empty($this->answer)) {
                $this->matter->answer = $this->answer->get();
            }

            $saved = $this->matter->save();

            $output = Admin::correctAnswer($this->matter->chapter->language->type, $this->matter->id, $this->matter->answer);

            if ($output!="") {
                $this->emit('swal', 'error', $output);
            } else {
                if ($saved) {
                    $this->emit('success', 'Instruksi berhasil disimpan.');
                    $this->emitTo('matter.grid', 'reloadMatters', $this->matter->chapter->id);
                } else {
                    $this->emit('error', 'Materi gagal disimpan.');
                }
            }
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('matter.modal-matter-instruction');
    }
}
