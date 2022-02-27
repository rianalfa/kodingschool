<?php

namespace App\Http\Livewire\User;

use App\Models\Badge;
use App\Models\Language;
use App\Models\Study;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Profile extends Component
{
    private $user;
    private $badges;
    private $languages;

    public function mount($id=null) {
        $this->user = ($id==null) ? auth()->user() : User::whereId($id)->first();

        $languages = Language::get();

        foreach ($languages as $language) {
            $chapters = $language->chapters;
            $total = 0;
            $completed = 0;
            $point = 0;

            foreach ($chapters as $chapter) {
                $total += $chapter->matters()->count();
                $result = DB::table('studies')
                                    ->select(DB::raw('count(*) as completed'), DB::raw('SUM(studies.point) as point'))
                                    ->join('matters', 'studies.matter_id', '=', 'matters.id')
                                    ->where('matters.chapter_id', $chapter->id)
                                    ->where('studies.user_id', $this->user->id)
                                    ->where('studies.finished', '1')
                                    ->first();
                $completed += $result->completed;
                $point += $result->point;
            }

            $language->total = $total;
            $language->completed = $completed;
            $language->progress = $language->total!=0 ? floor($completed/$total*100) : 0;
            $language->point = $point;
        }

        $this->languages = $languages;
        $this->badges = Badge::where('user_id', $this->user->id)->get();
    }

    public function render()
    {
        return view('user.profile', [
            'user' => $this->user,
            'languages' => $this->languages,
            'badges' => $this->badges,
        ]);
    }
}
