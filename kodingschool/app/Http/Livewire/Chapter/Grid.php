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

    public $ch = '';
    public $show = false;

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

    public function show($chapter) {
        if ($this->ch==$chapter && $this->show==true) {
            $this->ch = '';
            $this->show = false;
        } else {
            $this->ch = $chapter;
            $this->show = true;
            $this->emitTo('matter.grid', 'reloadMatters', $chapter);
        }
    }
}
