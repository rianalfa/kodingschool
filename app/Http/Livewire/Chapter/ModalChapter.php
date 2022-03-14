<?php

namespace App\Http\Livewire\Chapter;

use App\Models\Chapter;
use App\Models\Language;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalChapter extends ModalComponent
{
    public $languageId;
    public $chapter;

    protected function rules() {
        return [
            'chapter.name' => 'required|max:100|unique:chapters,name,'.$this->chapter->id.',id,language_id,'.$this->languageId,
            'chapter.number' => 'required|numeric',
            'chapter.description' => 'nullable|string',
        ];
    }

    public function mount($language, $id=null) {
        $this->languageId = $language;

        if ($id!=null) {
            $this->chapter = Chapter::whereId($id)->first();
        } else {
            $this->chapter = new Chapter();
        }
    }

    public function addNewChapter() {
        if (auth()->user()->hasRole('admin')) {
            $this->validate();
            $this->chapter->language_id = $this->languageId;
            $saved = $this->chapter->save();

            if ($saved) {
                $this->emit('success', 'Bab berhasil disimpan.');
                $this->emitTo('language.show', 'reloadLanguage');
            } else {
                $this->emit('error', 'Bab gagal disimpan.');
            }
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('chapter.modal-chapter');
    }
}
