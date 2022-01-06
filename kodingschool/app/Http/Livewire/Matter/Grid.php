<?php

namespace App\Http\Livewire\Matter;

use App\Models\Chapter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Grid extends Component
{
    public $chapter;
    public $availableMatter;
    private $matters;

    protected $listeners = [
        'reloadMatters' => 'reload',
    ];

    public function mount() {
        $this->matters = Chapter::find($this->chapter)->matters()->get();
    }

    public function reload($chapter) {
        $this->matters = Chapter::find($chapter)->matters()->get();
        $this->chapter = $chapter;

        $studies = DB::table('studies')
            ->select('matters.number')
            ->leftJoin('matters', 'studies.matter_id', '=', 'matters.id')
            ->orderBy('matters.number', 'desc')
            ->where('matters.chapter_id', '=', $chapter)
            ->where('studies.user_id', '=', Auth::user()->id)
            ->get();

        $this->availableMatter = (sizeof($studies) == 0) ? 1 : $studies[0]->number;
    }

    public function render()
    {
        return view('matter.grid', [
            'matters' => $this->matters,
        ]);
    }
}
