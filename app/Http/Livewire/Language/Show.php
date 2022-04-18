<?php

namespace App\Http\Livewire\Language;

use App\Http\Controllers\Badge;
use App\Http\Controllers\Matter as ControllersMatter;
use App\Models\Chapter;
use App\Models\Difficulty;
use App\Models\Language;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $languageId;
    public $activeChapter;
    private $language;
    private $chapters;

    protected $listeners = [
        'reloadLanguage' => 'reload',
    ];

    public function mount($id) {
        $this->languageId = $id;
        $chapter = Chapter::where('language_id', $id)->orderBy('number', 'asc')->first();
        $this->activeChapter = !empty($chapter) ? $chapter->id : null;
    }

    public function reload() {
        $this->language = Language::whereId($this->languageId)->first();
        $this->chapters = Chapter::where('language_id', $this->languageId)->orderBy('number', 'asc')->get();
        if (!count($this->language->chapters()->get()) && auth()->user()->hasRole('user')) {
            session()->flash('message', 'Maaf, materi untuk bahasa ini belum tersedia!');
            return redirect()->to('/dashboard');
        }
    }

    public function checkDetail($id) {
        $this->activeChapter = $id;
        $this->emitTo('chapter.show', 'reloadChapter', $id);
        $this->emitTo('matter.grid', 'reloadMatters', $id);
        $this->emit('goToTop');
    }

    public function render()
    {
        $this->reload();
        return view('language.show', [
            'language' => $this->language,
            'chapters' => $this->chapters,
        ]);
    }
}
