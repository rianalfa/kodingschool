<?php

namespace App\Http\Livewire\Matter;

use App\Models\Chapter;
use App\Models\Matter;
use App\Models\Study;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Grid extends Component
{
    public $chapterId;
    private $matters;

    protected $listeners = [
        'reloadMatters' => 'reload',
    ];

    public function reload($id=null) {
        if ($id!=null) $this->chapterId = $id;

        $this->matters = Matter::where('chapter_id', $this->chapterId)->orderBy('number', 'asc')->get();
    }

    public function render()
    {
        $this->reload($this->chapterId);
        return view('matter.grid', [
            'matters' => $this->matters,
        ]);
    }

    public function matterNotAvailable() {
        $this->emit('swal', 'error', 'Maaf, materi ini belum tersedia untukmu! Silahkan arungi materi secara bertahap!');
    }
}
