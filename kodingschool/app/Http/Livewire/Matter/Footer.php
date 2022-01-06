<?php

namespace App\Http\Livewire\Matter;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Footer extends Component
{
    private $detail;
    private $level;
    private $nextLevel;

    public function mount() {
        $this->detail = User::find(Auth::user())->first()->detail()->first();

        $this->level = $this->detail->level()->first();

        $this->nextLevel = ($this->level->point - ($this->level->point_total - $this->detail->point))/$this->level->point;
    }

    public function next() {
        $this->emitTo('matter.show', 'nextMatter');
    }

    public function render()
    {
        return view('matter.footer', [
            'level' => $this->level,
            'nextLevel' => $this->nextLevel,
        ]);
    }
}
