<?php

namespace App\Http\Livewire\Matter;

use Livewire\Component;

class Iframe extends Component
{
    public $text;

    protected $listeners = [
        'reloadIframe' => 'reload'
    ];

    public function reload($text) {
        $this->text = $text;
    }

    public function render()
    {
        $this->reload($this->text);
        return view('matter.iframe');
    }
}
