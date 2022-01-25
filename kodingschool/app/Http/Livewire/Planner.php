<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Planner extends Component
{
    public $disabled = true;
    public $planner;
    public $note;
    private $days = [
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
    ];

    public function mount() {
        $planner = User::whereId(Auth::user()->id)->first()->planner()->first();

        foreach ($this->days as $i => $day) {
            if ($planner[$day]=="1") {
                if (date('w') > $i) {
                    DB::table('planners')->whereId($planner->id)->update([$day => "2"]);
                } elseif (date('w') == $i) {
                    DB::table('planners')->whereId($planner->id)->update([$day => "3"]);
                }
            } elseif ($planner[$day]!="0") {
                if (date('w') < $i) {
                    DB::table('planners')->whereId($planner->id)->update([$day => "1"]);
                }
            }
        }
    }

    public function reload() {
        $this->planner = User::whereId(Auth::user()->id)->first()->planner()->first();
        $this->note = $this->planner->note;
    }

    public function render()
    {
        $this->reload();
        return view('planner', [
            'days' => $this->days,
        ]);
    }

    public function editPlanner() {
        $this->disabled = !$this->disabled;
    }

    public function setPlanner($day) {
        if ($this->planner[$day]=="0") {
            $this->planner[$day] = "1";
        } else {
            $this->planner[$day] = "0";
        }
        DB::table('planners')->whereId($this->planner->id)->update([$day => $this->planner[$day]]);
    }

    public function editNote() {
        DB::table('planners')->whereId($this->planner->id)->update(['note' => $this->note]);
    }
}
