<?php

namespace App\Http\Livewire\Matter;

use Livewire\Component;
use App\Models\Matter;

class Question extends Component
{
    public $matter;
    public $question;

    protected $listeners = [
        'reloadMatterQuestion' => 'reload',
    ];

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();
    }

    public function render()
    {
        $this->question = $this->matter->question;
        return view('matter.question');
    }
}
