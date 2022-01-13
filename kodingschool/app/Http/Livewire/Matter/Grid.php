<?php

namespace App\Http\Livewire\Matter;

use App\Models\Chapter;
use App\Models\Study;
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

        $studies = Study::select('matters.id')
                        ->leftJoin('matters', 'studies.matter_id', '=', 'matters.id')
                        ->where('matters.chapter_id', '=', $this->chapter)
                        ->where('studies.user_id', '=', Auth::user()->id)
                        ->orderBy('matters.number', 'asc')
                        ->get();

        if (count($studies)) {
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
            'buttonsStyling' => false,
            'customClass' => [
                'confirmButton' => 'font-semibold text-sm tracking-widest bg-red-500 hover:bg-red-400 text-white rounded-md active:bg-red-400 focus:border-red-400 focus:ring-red-300 anchor-button py-2 px-4'
            ],
        ]);
    }
}
