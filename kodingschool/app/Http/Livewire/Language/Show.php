<?php

namespace App\Http\Livewire\Language;

use App\Models\Chapter;
use App\Models\Difficulty;
use App\Models\Language;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $language;

    protected $listeners = [
        'reloadAll' => '$refresh',
    ];

    public function mount($id) {
        $this->language = Language::whereId($id)->first();
        if (!count($this->language->chapters()->get())) {
            session()->flash('message', 'Maaf, materi untuk bahasa ini belum tersedia');
            return redirect()->to('/dashboard');
        }
    }

    public function render()
    {
        return view('language.show');
    }

    public function openModal($id) {
        $this->dispatchBrowserEvent('modal', [
            'type' => 'open',
            'id' => $id,
        ]);
    }
}
