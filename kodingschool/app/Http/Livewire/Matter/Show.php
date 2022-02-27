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
        ControllersMatter::checkNewStudy($id);
    }

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();
        $this->point = $this->matter->difficulty()->first()->point;
        $this->question = Study::where('user_id', auth()->user()->id)->where('matter_id', $id)->first()->user_answer ?? $this->matter->question;

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
            $isItCorrect = ControllersMatter::checkAnswer($this->matter, $this->question);

            if ($isItCorrect==="1") {
                ControllersMatter::correctAnswer($this->matter->id, $this->point, $this->question);

                $this->emit('success', 'Jawabanmu benar.');
                $this->correctAnswer();
            } elseif ($isItCorrect==="0") {
                $this->emit('error', 'Jawabanmu belum tepat.');
                $this->point = ($this->point === 0) ? 0 : $this->point-25;
                $this->reload($this->matter->id);
            } else {
                $this->emit('swal', 'error', $isItCorrect);
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

        if ($this->matter == 'finished') {
            $this->emit('swal', 'success', 'Kamu telah menyelesaikan seluruh materi yang ada pada bahasa ini!');
        } else {
            ControllersMatter::checkNewStudy($this->matter->id);
            $this->emitTo('matter.question', 'reloadQuestion', $this->matter->id);
            $this->reload($this->matter->id);
        }
    }

    public function checkAnswer() {
        $lines = file('../storage/app/answers/corrects/2/39/40.cpp');
        $result = '';

        if (str_contains(json_encode($lines), 'cin')) {
            foreach ($lines as $line) {
                if (str_contains($line, 'int main')) {
                    $result .= 'int main(int argc, char* argv[]) {'.PHP_EOL;
                } elseif (str_contains($line, 'cin')) {
                    $variables = explode('>>', $line);
                    $variables[1] = str_replace(';', '', $variables[1]);
                    $result .= str_replace(' ', '', $variables[1]).' = argv[0];'.PHP_EOL;
                    $result .= 'return 0;'.PHP_EOL;
                } else {
                    $result .= $line;
                }
            }
            Storage::disk('local')->put('/answers/corrects/2/39/40.cpp', $result);

            exec("g++ ../storage/app/answers/corrects/2/39/40.cpp -O3 -o ../storage/app/answers/corrects/2/39/40.exe  2>&1", $outputCompiler);
            exec("cd .. && cd storage/app/answers/corrects/2/39 && 40.exe", $output);
            $this->emitTo('matter.shell', 'reloadShell', json_encode($output));
        } else {
            exec("g++ ../storage/app/answers/corrects/2/39/40.cpp -O3 -o ../storage/app/answers/corrects/2/39/40.exe  2>&1", $outputCompiler);
            exec("cd .. && cd storage/app/answers/corrects/2/39 && 40.exe 1", $output);
            $this->emit('consolelog', $output);
        }
        $this->reload($this->matter->id);
    }

    public function render()
    {
        return view('matter.show')
                ->layout('layouts.matter');
    }
}
