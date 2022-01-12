<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Leaderboard extends Component
{
    private $leaderboard;
    public $type = 'day';

    protected $listeners = [
        'reloadBoard' => 'reload',
    ];

    public function reload() {
        switch ($this->type) {
            case 'day':
                $this->leaderboard = DB::table('results')
                                        ->selectRaw('results.user_id, users.name, results.point as points')
                                        ->leftJoin('users', 'results.user_id', '=', 'users.id')
                                        ->where('results.date', date('Y-m-d'))
                                        ->get();
                break;
            case 'month' :
                $this->leaderboard = DB::table('results')
                                        ->selectRaw('results.user_id, users.name, sum(results.point) as points')
                                        ->leftJoin('users', 'results.user_id', '=', 'users.id')
                                        ->groupBy('results.user_id', 'users.name')
                                        ->where('results.date', 'like', date('Y-m').'%')
                                        ->get();
                break;
            case 'total' :
                $this->leaderboard = DB::table('results')
                                        ->selectRaw('results.user_id, users.name, sum(results.point) as points')
                                        ->leftJoin('users', 'results.user_id', '=', 'users.id')
                                        ->groupBy('results.user_id', 'users.name')
                                        ->get();
                break;
        }
    }

    public function render()
    {
        $this->reload();
        return view('leaderboard', [
            'leaderboard' => $this->leaderboard,
        ]);
    }

    public function boardChange($type) {
        $this->type = $type;
        $this->emit('reloadBoard');
    }
}
