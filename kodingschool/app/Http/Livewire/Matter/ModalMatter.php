<?php

namespace App\Http\Livewire\Matter;

use App\Http\Controllers\Admin;
use App\Models\Chapter;
use App\Models\Difficulty;
use App\Models\Matter;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalMatter extends ModalComponent
{
    public $matter;
    public $chapterId;
    public $difficulties;

    protected function rules() {
        return [
            'matter.name' => 'required|max:25|unique:matters,name,NULL,id,chapter_id,'.$this->chapterId,
            'matter.number' => 'required|unique:matters,number,NULL,id,chapter_id,'.$this->chapterId,
            'matter.matter' => 'required|string',
            'matter.difficulty_id' => 'required|exists:difficulties,id',
            'matter.instruction' => 'string',
            'matter.answer' => 'string',
            'matter.question' => 'string',
            'matter.hint' => 'string',
        ];
    }

    public function mount($chapter, $id=null) {
        $this->chapterId = $chapter;

        if ($id!=null) {
            $this->matter = Matter::whereId($id)->first();
        } else {
            $this->matter = new Matter();
        }
        $this->difficulties = Difficulty::get();
        $this->matter->difficulty_id = $this->difficulties[0]->id;
    }

    public function addNewMatter() {
        if (auth()->user()->hasRole('admin')) {
            $this->validate();
            $this->matter->chapter_id = $this->chapterId;

            $saved = $this->matter->save();

            if(!empty($this->matter->instruction))
                Admin::correctAnswer($this->matter->chapter->language->type, $this->matter->id, $this->matter->answer);

            if ($saved) {
                $this->emit('success', 'Materi berhasil disimpan.');

                $this->emitTo('language.show', 'reloadLanguage');
                $this->emitTo('language.chapter', 'reloadChapter', $this->chapterId);
                $this->emitTo('matter.grid', 'reloadMatters', $this->chapterId);
            } else {
                $this->emit('error', 'Materi gagal disimpan.');
            }
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('matter.modal-matter');
    }
}
