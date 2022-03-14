<?php

namespace App\Http\Livewire\Matter;

use App\Models\Matter;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalDelete extends ModalComponent
{
    public $name;
    public $matterId;
    public $chapterId;

    public function mount($chapter, $id=null) {
        $this->chapterId = $chapter;
        $this->matterId = $id;

        if ($id!=null) {
            $this->name = Matter::whereId($id)->first()->name;
        } else {
            $this->name = "";
        }
    }

    public function deleteMatter() {
        if (auth()->user()->hasRole('admin')) {
            $deleted = Matter::whereId($this->matterId)->delete();
            if ($deleted) {
                $this->emit('success', 'Materi '.$this->name.' berhasil dihapus.');
            } else {
                $this->emit('error', 'Materi '.$this->name.' gagal dihapus.');
            }
            $this->emitTo('language.show', 'reloadLanguage');
            $this->emitTo('language.chapter', 'reloadChapter', $this->chapterId);
            $this->emitTo('matter.grid', 'reloadMatters', $this->chapterId);
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('matter.modal-delete');
    }
}
