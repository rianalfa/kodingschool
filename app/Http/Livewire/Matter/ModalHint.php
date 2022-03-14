<?php

namespace App\Http\Livewire\Matter;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalHint extends ModalComponent
{
    public $hint;

    public function mount($hint) {
        $this->hint = $hint;
    }

    public function render()
    {
        return view('matter.modal-hint');
    }
}
