<?php

namespace App\Http\Livewire\Matter;

use App\Models\Chapter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Grid extends Component
{
    public $chapter;
    private $availableMatter = [];
    private $matters;

    protected $listeners = [
        'reloadMatters' => 'reload',
    ];

    public function reload() {
        $this->matters = Chapter::whereId($this->chapter)->first()->matters()->get();

        $studies = DB::table('studies')
                    ->select('matters.id')
                    ->leftJoin('matters', 'studies.matter_id', '=', 'matters.id')
                    ->where('matters.chapter_id', '=', $this->chapter)
                    ->where('studies.user_id', '=', Auth::user()->id)
                    ->orderBy('matters.number', 'asc')
                    ->get();

        if (!empty($studies)) {
            foreach ($studies as $study) {
                array_push($this->availableMatter, $study->id);
            }
        } else {
            $this->availableMatter = [1];
        }
    }

    public function render()
    {
        $this->reload();
        return view('matter.grid', [
            'matters' => $this->matters,
            'availableMatter' => $this->availableMatter
        ]);
    }

    public function matterNotAvailable() {
        $this->dispatchBrowserEvent('swal', [
            'icon' => 'error',
            'title' => '',
            'text' => 'Maaf, materi ini belum tersedia untukmu! Silahkan arungi materi secara bertahap!',
        ]);
    }
}
