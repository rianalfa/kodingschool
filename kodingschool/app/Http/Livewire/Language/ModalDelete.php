<?php

namespace App\Http\Livewire\Language;

use App\Models\Chapter;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalDelete extends ModalComponent
{
    public $name;
    public $languageId;

    protected $rules = [
        'name' => 'required|unique:languages',
    ];

    public function mount($id=null) {
        $this->languageId = $id;

        if ($id!=null) {
            $this->name = Language::whereId($id)->first()->name;
        } else {
            $this->name = "";
        }
    }

    public function deleteLanguage() {
        if (auth()->user()->hasRole('admin')) {
            Chapter::where('language_id', $this->languageId)->delete();
            $deleted = Language::whereId($this->languageId)->delete();
            if ($deleted) {
                if (Storage::exists('images/languages/'.$this->languageId.'.jpeg')) {
                    Storage::delete('images/languages/'.$this->languageId.'.jpeg');
                }

                $this->emit('success', 'Bahasa '.$this->name.' berhasil dihapus.');
            } else {
                $this->emit('error', 'Bahasa '.$this->name.' gagal dihapus.');
            }
            $this->emitTo('language.grid', 'reloadLanguages');
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('language.modal-delete');
    }
}
