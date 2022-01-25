<?php

namespace App\Http\Livewire\Matter;

use Livewire\Component;
use App\Models\Matter;
use App\Models\Planner;
use App\Models\Study;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Show extends Component
{
    public $matter;

    protected $listeners = [
        'reloadMatter' => '$refresh',
        'nextMatter' => 'next',
        'correctAnswer' => 'correctAnswer',
        'showHint' => 'showHint',
    ];

    public function mount($id) {
        $this->matter = Matter::whereId($id)->first();
        $this->newStudy();

        $today = strtolower(date("l"));
        $planner = User::whereId(Auth::user()->id)->first()->planner()->first();
        if ($planner[$today]=="1") {
            DB::table('planners')->whereId($planner->id)->update([$today => "3"]);
        }
    }

    public function newStudy() {
        if (empty(Study::where('user_id', Auth::user()->id)->where('matter_id', $this->matter->id)->first())) {
            Study::insert([
                'user_id' => Auth::user()->id,
                'matter_id' => $this->matter->id,
                'user_answer' => "",
                'point' => 0,
            ]);
        }
    }

    public function next() {
        if (!empty($this->matter->question)) {
            $this->emitTo('matter.question', 'checkAnswer');
        }
    }

    public function correctAnswer() {
        $this->matter = Matter::next($this->matter->number, $this->matter->chapter_id);

        if ($this->matter == 'finished') {
            $this->dispatchBrowserEvent('swal', [
                'icon' => 'success',
                'iconColor' => '#0ea5e9',
                'title' => 'Selamat!',
                'text' => 'Kamu telah menyelesaikan seluruh materi yang ada pada bahasa ini!',
                'timer' => 5000,
                'buttonsStyling' => false,
                'customClass' => [
                    'confirmButton' => 'font-semibold text-sm tracking-widest bg-sky-500 hover:bg-sky-400 text-white rounded-md active:bg-sky-400 focus:border-sky-400 focus:ring-sky-300 anchor-button py-2 px-4'
                ],
            ]);
        } else {
            $this->newStudy();
            $this->emitTo('matter.detail', 'reloadMatterDetail', $this->matter->id);
            $this->emitTo('matter.question', 'reloadMatterQuestion', $this->matter->id);
            $this->emit('reloadMatter');
        }
    }

    public function openModal($id) {
        $this->dispatchBrowserEvent('modal', [
            'type' => 'open',
            'id' => $id,
        ]);
    }

    public function render()
    {
        return view('matter.show')
                ->layout('layouts.matter');
    }

    public function showHint() {
        $this->openModal('hintModal');
    }
}
