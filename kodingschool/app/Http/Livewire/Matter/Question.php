<?php

namespace App\Http\Livewire\Matter;

use App\Models\Level;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Matter;
use App\Models\Result;
use App\Models\Study;
use App\Models\User;
use App\Models\UserDetail;

class Question extends Component
{
    public $matter;
    public $question;
    public $point;

    protected $listeners = [
        'reloadMatterQuestion' => 'reload',
        'checkAnswer' => 'checkAnswer',
    ];

    public function mount() {
        $this->question = $this->matter->question;
        $this->point = $this->matter->difficulty()->first()->point;
    }

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();
        $this->question = $this->matter->question;
        $this->point = $this->matter->difficulty()->first()->point;
    }

    public function render()
    {
        return view('matter.question');
    }

    public function checkAnswer() {
        if ($this->question === $this->matter->answer) {
            $this->dispatchBrowserEvent('swal', [
                'icon' => 'success',
                'title' => 'Jawaban Benar',
                'timer' => 5000
            ]);

            $user = User::whereId(Auth::user()->id)->first();

            $point = $user->detail()->first()->point;
            $point = $point+$this->point;

            $study = Study::where('user_id', $user->id)->where('matter_id', $this->matter->id);

            if ($study->first()->point==0) {
                $result = Result::where('user_id', $user->id)->where('date', date('Y-m-d'))->first();

                if (!empty($result)) {
                    Result::where('user_id', $user->id)
                            ->where('date', date('Y-m-d'))
                            ->update(['point' => $result->point + $this->point]);
                } else {
                    Result::insert([
                        'user_id' => $user->id,
                        'point' => $this->point,
                        'date' => date('Y-m-d'),
                    ]);
                }

                if ($point >= Level::whereId($user->detail()->first()->level_id)->first()->point_total) {
                    $level = Level::where('point_total', '<=', $point)->orderBy('id', 'desc')->first();

                    UserDetail::where('user_id', $user->id)->update([
                        'point' => $point,
                        'level_id' => $level->id+1,
                    ]);
                } else {
                    UserDetail::where('user_id', $user->id)->update([
                        'point' => $point,
                    ]);
                }
            }

            $study->update([
                    'user_answer' => $this->question,
                    'point' => $this->point,
                ]);

            $this->emitTo('matter.show', 'correctAnswer');
            $this->emitTo('matter.footer', 'reloadLevel');
        } else {
            $this->dispatchBrowserEvent('swal', [
                'icon' => 'error',
                'title' => 'Jawaban Salah',
                'timer' => 5000
            ]);
            $this->point = ($this->point === 0) ? 0 : $this->point-25;
        }
    }
}
