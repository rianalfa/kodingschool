<?php

namespace App\Http\Livewire\Matter;

use App\Http\Controllers\Badge;
use App\Http\Controllers\Matter as ControllersMatter;
use Livewire\Component;
use App\Models\Matter;
use App\Models\Planner;
use App\Models\Study;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'nextMatter' => 'nextMatter',
        'javaScriptAnswer' => 'javaScriptAnswer',
    ];

    public function mount($id) {
        ControllersMatter::checkPlanner();
        ControllersMatter::checkNewStudy($id);

        $badge = Badge::studious();
        if (!empty($badge)) {
            $this->emit('success', 'Selamat, kamu berhasil mendapatkan badge '.$badge->badge->name);
        }

        $study = Study::where('user_id', auth()->user()->id)->where('matter_id', $id)->first();
        $this->question = !empty($study->user_answer) ? $study->user_answer : Matter::whereId($id)->first()->question;

        $this->reload($id);
    }

    public function initiateViewer() {
        if ($this->matter->instruction!="") {
            $this->emit('viewer', 'matter', Str::markdown($this->matter->matter).'<div class="w-full mt-6">
                <div class="bg-gray-300 rounded-t-lg py-2 px-4">
                    <p class="text-gray-800 text-lg font-bold">Instruksi</p>
                </div>
                <div class="bg-white border-x-2 border-b-2 border-gray-300 rounded-b-lg py-2 px-2">
                    <p class="text-justify px-4">'.Str::markdown($this->matter->instruction).'</p></div>
                </div>');
        } else {
            $this->emit('viewer', 'matter', Str::markdown($this->matter->matter));
        }
    }

    public function initiateCodeEditor() {
        $this->emit('codeEditor', 'code', $this->matter->chapter->language->mode);
    }

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();
        if ($this->matter->instruction==null) $this->matter->instruction="";

        $this->nextLevel = ControllersMatter::checkNextLevel();
    }

    public function nextMatter($question) {
        if ($this->matter->chapter->language->type!="html") {
            $this->next($question);
        } else {
            $this->nextHTML($question);
        }
    }

    public function next($question, $hashValue=0) {
        $levelUp="no";
        if (!empty($this->matter->instruction)) {
            $this->question = $question;

            $output = ControllersMatter::checkAnswer($this->matter, $this->question, $hashValue);

            $study = Study::where('matter_id', $this->matter->id)->where('user_id', auth()->user()->id)->first();
            $study->update(['user_answer' => $this->question]);

            if ($output['status']==="1") {
                $this->emitTo('matter.shell', 'reloadShell', $output['output']);
                $this->emitTo('matter.iframe', 'reloadIframe', "");

                $levelUp = ControllersMatter::correctAnswer($this->matter->id, $this->question);
                $this->emit('success', 'Jawabanmu benar.');
                $this->correctAnswer();
            } elseif ($output['status']==="0") {
                if ($study->finished=="0") $study->update(['point' => ($study->point - 25) ]);
                $this->emitTo('matter.shell', 'reloadShell', $output['output']);
                $this->emitTo('matter.iframe', 'reloadIframe', $question);

                $this->emit('error', 'Jawabanmu belum tepat.');
                $this->reload($this->matter->id);
            } else {
                $this->emitTo('matter.shell', 'reloadShell', $output['output']);
                $this->emit('error', 'Jawabanmu belum tepat.');
                $this->reload($this->matter->id);
            }
        } else {
            $levelUp = ControllersMatter::correctAnswer($this->matter->id, $this->matter->question);
            $this->correctAnswer();
            $this->emit('success', 'Yeay, kamu menyelesaikan materi ini');
        }

        if ($levelUp=="yes") {
            if (auth()->user()->detail->level_id==100) {
                $badge = Badge::master();
                if (!empty($badge)) {
                    $this->emit('success', 'Selamat, kamu berhasil mendapatkan badge '.$badge->badge->name);
                }
            }
            $this->emit('swal', 'success', 'Yeay! Kau naik level.');
        }
    }

    public function nextHTML($question) {
        $this->emit('javaScriptChecker', $question);
    }

    public function javaScriptAnswer($question, $hashValue) {
        Storage::disk('local')->put('./answers/users/'.$this->matter->chapter->language->id.'/'.$this->matter->chapter->id.'/'.$this->matter->id.'/'.auth()->user()->username.'.txt', $hashValue);
        $this->next($question, $hashValue);
    }

    public function correctAnswer() {
        $matter = Matter::next($this->matter->number, $this->matter->chapter_id);

        $badge = Badge::gamer();
        if (!empty($badge)) {
            $this->emit('success', 'Selamat, kamu berhasil mendapatkan badge '.$badge->badge->name);
        }

        if ($this->matter->difficulty_id==1) {
            $badge = Badge::debugger($this->matter->id);
        } elseif ($this->matter->difficulty_id==2) {
            $badge = Badge::hardWorker($this->matter->id);
        }
        if (!empty($badge)) {
            $this->emit('success', 'Selamat, kamu berhasil mendapatkan badge '.$badge->badge->name);
        }

        if ($matter[0] == 'finished') {
            for ($i='1'; $i<='3'; $i++) {
                $badge = Badge::mrPerfect($this->matter->id, $i);
                if (!empty($badge)) {
                    $this->emit('success', 'Selamat, kamu berhasil mendapatkan badge '.$badge->badge->name);
                }
            }
            $this->emit('swal', 'success', 'Kamu telah menyelesaikan seluruh materi yang ada pada bahasa ini!');
        } else {
            for ($i='1'; $i<='2'; $i++) {
                $badge = Badge::mrPerfect($this->matter->id, $i);
                if (!empty($badge)) {
                    $this->emit('success', 'Selamat, kamu berhasil mendapatkan badge '.$badge->badge->name);
                }
            }

            $this->matter = $matter[1];
            if ($this->matter->instruction==null) $this->matter->instruction="";

            $study = Study::where('user_id', auth()->user()->id)->where('matter_id', $this->matter->id)->first();
            $this->question = !empty($study->user_answer) ? $study->user_answer : $this->matter->question;

            $this->initiateViewer();
            if (!empty($this->matter->instruction)) $this->initiateCodeEditor();

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
