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
use Illuminate\Support\Facades\Storage;

class Show extends Component
{
    public $matter;
    public $question;
    public $nextLevel;

    protected $listeners = [
        'reloadMatter' => 'reload',
        'nextMatter' => 'next',
        'correctAnswer' => 'correctAnswer',
        'showHint' => 'showHint',
    ];

    public function mount($id) {
        ControllersMatter::checkPlanner();
        ControllersMatter::checkNewStudy($id);

        $study = Study::where('user_id', auth()->user()->id)->where('matter_id', $id)->first();
        $this->question = !empty($study->user_answer) ? $study->user_answer : $this->matter->question;

        $this->reload($id);
    }

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();

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
            $output = ControllersMatter::checkAnswer($this->matter, $this->question);

            $study = Study::where('matter_id', $this->matter->id)->where('user_id', auth()->user()->id)->first();
            $study->update(['user_answer' => $this->question]);

            if ($output['status']==="1") {
                $this->emitTo('matter.shell', 'reloadShell', $output['output'][0]);

                ControllersMatter::correctAnswer($this->matter->id, $this->question);
                $this->emit('success', 'Jawabanmu benar.');
                $this->correctAnswer();
            } elseif ($output['status']==="0") {
                $this->emit("consolelog", 'reloadShell', $output['output'][0]);
                $study->update(['point' => ($study->point - 25) ]);

                $this->emit('error', 'Jawabanmu belum tepat.');
                $this->reload($this->matter->id);
            } else {
                $study = Study::where('matter_id', $this->matter->id)->where('user_id', auth()->user()->id)->first();
                $study->update(['point' => ($study->point - 25) ]);

                $this->emit('swal', 'error', $output['output']);
                $this->emit('error', 'Jawabanmu belum tepat.');
                $this->reload($this->matter->id);
            }
        } else {
            ControllersMatter::correctAnswer($this->matter->id, $this->point);
            $this->correctAnswer();
        }
    }

    public function correctAnswer() {
        $this->matter = Matter::next($this->matter->number, $this->matter->chapter_id);
        $study = Study::where('user_id', auth()->user()->id)->where('matter_id', $this->matter->id)->first();
        $this->question = !empty($study->user_answer) ? $study->user_answer : $this->matter->question;

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
