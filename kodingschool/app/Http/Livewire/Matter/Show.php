<?php

namespace App\Http\Livewire\Matter;

use Livewire\Component;
use App\Models\Matter;

class Show extends Component
{
    private $matter;
    public $m;

    protected $listeners = [
        'reloadMatter' => '$refresh',
        'nextMatter' => 'next',
    ];

    public function reload() {
        $this->matter = $this->m;
    }

    public function next() {
        $this->reload();
        $this->matter = Matter::next($this->matter->id, $this->matter->chapter_id);
        $this->m = $this->matter;
        $this->emitTo('matter.detail', 'reloadMatterDetail', $this->matter->id);
        $this->emitTo('matter.question', 'reloadMatterQuestion', $this->matter->id);
        $this->emit('reloadMatter');
    }

    public function render()
    {
        $this->reload();
        return view('matter.show', [
            'matter' => $this->matter,
        ]);
    }
}
