<?php

namespace App\Http\Livewire\Matter;

use Livewire\Component;
use App\Models\Matter;
use App\Models\Study;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public $matter;

    protected $listeners = [
        'reloadMatter' => '$refresh',
        'nextMatter' => 'next',
        'correctAnswer' => 'correctAnswer',
    ];

    public function mount() {
        $this->newStudy();
    }

    public function newStudy() {
        if (empty(Study::where('user_id', Auth::user()->id)->where('matter_id', $this->matter->id)->first())) {
            Study::insert([
                'user_id' => Auth::user()->id,
                'matter_id' => $this->matter->id,
                'user_answer' => "",
                'point' => 0,
            ]);
        }
    }

    public function next() {
        if (!empty($this->matter->question)) {
            $this->emitTo('matter.question', 'checkAnswer');
        }
    }

    public function correctAnswer() {
        $this->matter = Matter::next($this->matter->number, $this->matter->chapter_id);

        if ($this->matter == 'finished') {
            $this->dispatchBrowserEvent('swal', [
                'icon' => 'success',
                'title' => 'Selamat!',
                'text' => 'Kamu telah menyelesaikan seluruh materi yang ada pada bahasa ini!',
                'timer' => 5000,
            ]);
        } else {
            $this->newStudy();
            $this->emitTo('matter.detail', 'reloadMatterDetail', $this->matter->id);
            $this->emitTo('matter.question', 'reloadMatterQuestion', $this->matter->id);
            $this->emit('reloadMatter');
        }
    }

    public function render()
    {
        return view('matter.show');
    }
}
