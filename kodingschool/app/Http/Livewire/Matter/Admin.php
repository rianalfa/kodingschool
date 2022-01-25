<?php

namespace App\Http\Livewire\Matter;

use App\Models\Chapter;
use App\Models\Difficulty;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Admin extends Component
{
    public $language;
    public $difficulty;
    public $chapters;

    public $name;
    public $matter;
    public $instruction;
    public $hint;
    public $answer;
    public $question;
    public $difficulty_id;
    public $number;
    public $chapter_id;

    protected function rules() {
        if ($this->instruction=="") {
            return [
                'name' => 'required|unique:matters|max:25',
                'matter' => 'required',
                'difficulty_id' => 'required|exists:difficulties,id',
                'number' => 'required',
                'chapter_id' => 'required|exists:chapters,id',
            ];
        } else {
            return [
                'name' => 'required|unique:matters|max:25',
                'matter' => 'required',
                'instruction' => 'required',
                'answer' => 'required',
                'question' => 'required',
                'difficulty_id' => 'required|exists:difficulties,id',
                'number' => 'required',
                'chapter_id' => 'required|exists:chapters,id',
            ];
        }
    }

    public function mount($id) {
        $this->language = $id;
        $this->difficulty = Difficulty::get();
        $this->chapters = Chapter::where('language_id', $id)->get();
        $this->difficulty_id = $this->difficulty[0]->id;
        $this->chapter_id = $this->chapters[0]->id;
    }

    public function render()
    {
        return view('matter.admin');
    }

    public function openModal($id) {
        $this->dispatchBrowserEvent('modal', [
            'type' => 'open',
            'id' => $id,
        ]);
    }

    public function closeModal($id) {
        $this->dispatchBrowserEvent('modal', [
            'type' => 'close',
            'id' => $id,
        ]);
    }

    public function addNewMatter() {
        if (User::findOrFail(Auth::user()->id)->hasRole('admin')) {
            $this->openModal('modalTambahMatter');
            $this->validate();

            $matter = Matter::create([
                'name' => $this->name,
                'number' => $this->number,
                'difficulty_id' => $this->difficulty_id,
                'matter' => $this->matter,
                'instruction' => $this->instruction,
                'answer' => $this->answer,
                'question' => $this->question,
                'hint' => $this->hint,
                'chapter_id' => $this->chapter_id,
            ]);

            if ($matter) {
                $this->dispatchBrowserEvent('swal', [
                    'icon' => 'success',
                    'iconColor' => '#0ea5e9',
                    'title' => 'Berhasil!',
                    'text' => 'Materi baru berhasil ditambahkan.',
                    'timer' => 5000,
                    'buttonsStyling' => false,
                    'customClass' => [
                        'confirmButton' => 'font-semibold text-sm tracking-widest bg-sky-500 hover:bg-sky-400 text-white rounded-md active:bg-sky-400 focus:border-sky-400 focus:ring-sky-300 anchor-button py-2 px-4'
                    ],
                ]);

                $this->closeModal('modalTambahMatter');
                $this->emitTo('language.show', 'reloadAll');
            }
        }
    }
}
