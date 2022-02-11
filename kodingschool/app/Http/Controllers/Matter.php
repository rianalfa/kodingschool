<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Planner;
use App\Models\Result;
use App\Models\Study;
use Illuminate\Http\Request;

class Matter extends Controller
{
    public static function checkPlanner() {
        $today = strtolower(date("l"));
        $planner = auth()->user()->planner()->first();
        if ($planner[$today]=="1") {
            Planner::whereId($planner->id)->update([$today => "3"]);
        }
    }

    public static function checkNewStudy($id) {
        if (empty(Study::where('user_id', auth()->user()->id)->where('matter_id', $id)->first())) {
            Study::insert([
                'user_id' => auth()->user()->id,
                'matter_id' => $this->matter->id,
                'user_answer' => "",
                'point' => 0,
            ]);
        }
    }

    public static function getCode($str) {
        $arr = [];
        $i=0;
        $str = strtok($str, "```");
        while ($str !== false) {
            if ($i%2 == 0) {
                $i++;
            } else {
                array_push($arr, $str);
                $i++;
            }

            $str = strtok("```");
        }

        return $arr;
    }

    public static function checkNextLevel() {
        $detail = auth()->user()->detail()->first();
        $level = $detail->level()->first();

        return ($level->point - ($level->point_total - $detail->point))/$level->point * 100;
    }

    public static function correctAnswer($matterId, $newPoint, $userAnswer="") {
        $user = auth()->user();

        $point = $user->detail()->first()->point;
        $point = $point+$newPoint;

        $study = Study::where('user_id', $user->id)->where('matter_id', $matterId);

        if ($study->first()->point==0) {
            $result = Result::where('user_id', $user->id)->where('date', date('Y-m-d'))->first();

            if (!empty($result)) {
                Result::where('user_id', $user->id)
                        ->where('date', date('Y-m-d'))
                        ->update(['point' => $result->point + $newPoint]);
            } else {
                Result::insert([
                    'user_id' => $user->id,
                    'point' => $newPoint,
                    'date' => date('Y-m-d'),
                ]);
            }

            if ($point >= Level::whereId($user->detail()->first()->level_id)->first()->point_total) {
                $level = Level::where('point_total', '<=', $point)->orderBy('id', 'desc')->first();

                $user->detail()->update([
                    'point' => $point,
                    'level_id' => $level->id+1,
                ]);
            } else {
                $user->detail()::where('user_id', $user->id)->update([
                    'point' => $point,
                ]);
            }
        }

        $study->update([
                'user_answer' => $userAnswer,
                'point' => $newPoint,
            ]);
    }
}
