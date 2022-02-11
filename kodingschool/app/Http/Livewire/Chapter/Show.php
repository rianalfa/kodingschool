<?php

namespace App\Http\Livewire\Chapter;

use App\Models\Chapter as ModelsChapter;
use Livewire\Component;

class Show extends Component
{
    public $chapterId;
    private $chapter;

    protected $listeners = [
        'reloadChapter' => 'reload',
    ];

    public function reload($id=null) {
        if ($id!=null) $this->chapterId = $id;
        $this->chapter = ModelsChapter::whereId($this->chapterId)->first();
    }

    public function render()
    {
        $this->reload($this->chapterId);
        return view('chapter.show', ['chapter' => $this->chapter]);
    }
}
