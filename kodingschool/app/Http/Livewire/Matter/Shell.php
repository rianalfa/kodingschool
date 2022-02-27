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

    public function render()
    {
        $this->reload($this->text);
        return view('matter.shell');
    }
}
