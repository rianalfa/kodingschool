<?php

namespace App\Http\Livewire\Chapter;

use App\Models\Chapter;
use App\Models\Matter;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalDelete extends ModalComponent
{
    public $name;
    public $chapterId;

    public function mount($id=null) {
        $this->chapterId = $id;

        if ($id!=null) {
            $this->name = Chapter::whereId($id)->first()->name;
        } else {
            $this->name = "";
        }
    }

    public function deleteChapter() {
        if (auth()->user()->hasRole('admin')) {
            Matter::where('chapter_id', $this->chapterId)->delete();
            $deleted = Chapter::whereId($this->chapterId)->delete();
            if ($deleted) {
                $this->emit('success', 'Bab '.$this->name.' berhasil dihapus.');
            } else {
                $this->emit('error', 'Bab '.$this->name.' gagal dihapus.');
            }
            $this->emitTo('language.show', 'reloadLanguage');
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('chapter.modal-delete');
    }
}
