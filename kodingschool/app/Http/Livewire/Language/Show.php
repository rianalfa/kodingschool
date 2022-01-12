<?php

namespace App\Http\Livewire\Language;

use App\Models\Language;
use Livewire\Component;

class Show extends Component
{
    private $language;

    public function mount($id) {
        $this->language = Language::whereId($id)->first();
    }

    public function render()
    {
        return view('language.show', ['language' => $this->language]);
    }
}
