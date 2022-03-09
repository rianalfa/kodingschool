<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Leaderboard extends Component
{
    private $leaderboard;
    private $userRank;
    public $type = 'day';

    protected $listeners = [
        'reloadBoard' => 'reload',
    ];

    public function reload() {
        switch ($this->type) {
            case 'day':
                $this->leaderboard = DB::table('results')
                                        ->selectRaw('results.user_id, users.username, users.name, results.point as points')
                                        ->leftJoin('users', 'results.user_id', '=', 'users.id')
                                        ->where('results.date', date('Y-m-d'))
                                        ->orderBy('points', 'desc')
                                        ->limit(100)
                                        ->get()->toArray();
                break;
            case 'month' :
                $this->leaderboard = DB::table('results')
                                        ->selectRaw('results.user_id, users.username, users.name, sum(results.point) as points')
                                        ->leftJoin('users', 'results.user_id', '=', 'users.id')
                                        ->groupBy('results.user_id', 'users.username', 'users.name')
                                        ->where('results.date', 'like', date('Y-m').'%')
                                        ->orderBy('points', 'desc')
                                        ->limit(100)
                                        ->get()->toArray();
                break;
            case 'total' :
                $this->leaderboard = DB::table('results')
                                        ->selectRaw('results.user_id, users.username, users.name, sum(results.point) as points')
                                        ->leftJoin('users', 'results.user_id', '=', 'users.id')
                                        ->groupBy('results.user_id', 'users.username', 'users.name')
                                        ->orderBy('points', 'desc')
                                        ->get()->toArray();
                break;
        }
        $index = array_search(auth()->user()->username, array_column($this->leaderboard, 'username'));
        $this->userRank = $index;
    }

    public function render()
    {
        $this->reload();
        return view('leaderboard', [
            'leaderboard' => $this->leaderboard,
            'userRank' => $this->userRank,
        ]);
    }

    public function boardChange($type) {
        $this->type = $type;
        $this->emit('reloadBoard');
    }
}
