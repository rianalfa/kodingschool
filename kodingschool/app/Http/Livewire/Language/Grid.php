<?php

namespace App\Http\Livewire\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Grid extends Component
{
    private $languages;

    protected $listeners = [
        'reloadLanguages' => 'reload'
    ];

    public function reload() {
        $this->languages = Language::all();
    }

    public function render()
    {
        $this->reload();
        return view('language.grid', [
            'languages' => $this->languages,
        ]);
    }
}
