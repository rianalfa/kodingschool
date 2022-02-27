<?php

namespace App\Http\Livewire\Matter;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Shell extends Component
{
    public $text;

    protected $listeners = [
        'reloadShell' => 'reload',
    ];

    public function reload($text) {
        $this->text = $text;
    }

    public function shellExec() {
        $lines = file('../storage/app/answers/corrects/2/39/40.cpp');

        if (substr_count(json_encode($lines), "return 0;") > 1) {
            $replaced = 0;
            $result='';

            foreach ($lines as $line) {
                if (str_contains($line, '= argv[0];') && $replaced==0) {
                    $text = explode(' ', $this->text);
                    $line = str_replace('argv[0]', end($text), $line);
                    $result .= $line.PHP_EOL;
                    $replaced++;
                } elseif (str_contains($line, 'return 0;') && $replaced==1) {
                    $replaced++;
                } else {
                    $result .= $line;
                }
            }

            Storage::disk('local')->put('/answers/corrects/2/39/40.cpp', $result);
        }

        exec("g++ ../storage/app/answers/corrects/2/39/40.cpp -O3 -o ../storage/app/answers/corrects/2/39/40.exe  2>&1", $outputCompiler);
        exec("cd .. && cd storage/app/answers/corrects/2/39 && 40.exe ".$this->text, $output);
        $this->emit('consolelog', json_encode($output));
        $this->reload(json_encode($output));
    }

    public function consoleOut() {
        $text = explode(' ', $this->text);
        $this->emit('consolelog', end($text));
    }

    public function render()
    {
        $this->reload($this->text);
        return view('matter.shell');
    }
}
