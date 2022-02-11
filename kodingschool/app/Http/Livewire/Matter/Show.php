<?php

namespace App\Http\Livewire\Matter;

use App\Http\Controllers\Matter as ControllersMatter;
use Livewire\Component;
use App\Models\Matter;
use App\Models\Planner;
use App\Models\Study;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Show extends Component
{
    public $matter;
    public $question;
    public $point;
    public $nextLevel;

    protected $listeners = [
        'reloadMatter' => 'reload',
        'nextMatter' => 'next',
        'correctAnswer' => 'correctAnswer',
        'showHint' => 'showHint',
    ];

    public function mount($id) {
        $this->reload($id);
        ControllersMatter::checkPlanner();
    }

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();
        $this->question = $this->matter->question;
        $this->point = $this->matter->difficulty()->first()->point;

        $this->matterCode();
        $this->nextLevel = ControllersMatter::checkNextLevel();
    }

    public function matterCode() {
        $this->matter->code = ControllersMatter::getCode($this->matter->matter);
        $this->matter->codeInstruction = ControllersMatter::getCode($this->matter->instruction);
        $this->matter->instruction = explode("```", $this->matter->instruction);
        $this->matter->matter = explode ("```", $this->matter->matter);
    }

    public function next() {
        if (!empty($this->matter->question)) {
            if ($this->question === $this->matter->answer) {
                ControllersMatter::correctAnswer($this->matter->id, $this->point, $this->question);

                $this->emit('success', 'Jawabanmu benar.');
                $this->correctAnswer();
            } else {
                $this->emit('error', 'Jawabanmu belum tepat.');
                $this->point = ($this->point === 0) ? 0 : $this->point-25;
                $this->reload($this->matter->id);
            }
        } else {
            ControllersMatter::correctAnswer($this->matter->id, $this->point);
            $this->correctAnswer();
        }
    }

    public function correctAnswer() {
        $this->matter = Matter::next($this->matter->number, $this->matter->chapter_id);

        if ($this->matter == 'finished') {
            $this->emit('swal', 'success', 'Kamu telah menyelesaikan seluruh materi yang ada pada bahasa ini!');
        } else {
            ControllersMatter::checkNewStudy($this->matter->id);
            $this->emitTo('matter.question', 'reloadQuestion', $this->matter->id);
            $this->reload($this->matter->id);
        }
    }

    public function render()
    {
        return view('matter.show')
                ->layout('layouts.matter');
    }
}
