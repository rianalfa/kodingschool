<?php

namespace App\Http\Livewire\Chapter;

use Livewire\Component;
use App\Models\Language;
use App\Models\Chapter;
use App\Models\Matter;
use Illuminate\Support\Facades\DB;

class Grid extends Component
{
    public $language;
    private $chapters;

    protected $listeners = [
        'reloadChapters' => 'reload'
    ];

    public function reload() {
        $this->chapters = $this->language->chapters()->get();
    }

    public function render()
    {
        $this->reload();
        return view('chapter.grid', [
            'chapters' => $this->chapters,
        ]);
    }
}
