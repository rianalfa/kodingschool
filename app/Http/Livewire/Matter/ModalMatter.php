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

    protected $listeners = [
        'saveMatter' => 'saveMatter',
    ];

    protected function rules() {
        return [
            'matter.name' => 'required|max:100|unique:matters,name,'.$this->matter->id.',id,chapter_id,'.$this->chapterId,
            'matter.number' => 'required|unique:matters,number,'.$this->matter->id.',id,chapter_id,'.$this->chapterId,
            'matter.matter' => 'required|string',
            'matter.difficulty_id' => 'required|exists:difficulties,id',
        ];
    }

    public function mount($chapter, $id=null) {
        $this->chapterId = $chapter;
        $this->matter = Matter::whereId($id)->first() ?? new Matter();
        if ($this->matter->matter==null) $this->matter->matter="";

        $this->difficulties = Difficulty::get();
        if (empty($this->matter->difficulty_id)) $this->matter->difficulty_id = $this->difficulties[0]->id;
    }

    public function saveMatter($matter) {
        if (auth()->user()->hasRole('admin')) {
            $this->matter->matter = $matter;
            $this->matter->chapter_id = $this->chapterId;
            $this->emit('matterEditor', $matter);

            $this->validate();

            $saved = $this->matter->save();

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

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('matter.modal-matter');
    }
}
