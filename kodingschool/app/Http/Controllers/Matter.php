<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Matter as ModelsMatter;
use App\Models\Planner;
use App\Models\Result;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Matter extends Controller
{
    public static function checkPlanner() {
        $today = strtolower(date("l"));
        $planner = auth()->user()->planner()->first();
        if ($planner[$today]=="1") {
            Planner::whereId($planner->id)->update([$today => "3"]);
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

    public static function checkAnswer($matter, $content) {
        $type = $matter->chapter->language->type;

        $path = "/answers/users/".$matter->chapter->language->id.'/'.$matter->chapter->id."/".$matter->id;
        Storage::disk('local')->put('.'.$path.'/'.auth()->user()->username.'.'.$type, $content);

        switch ($type) {
            case "cpp":
                exec("g++ ../storage/app".$path."/".auth()->user()->username.".cpp -O3 -o ../storage/app".$path."/".auth()->user()->username.".exe  2>&1", $outputCompiler);
                break;
        }

        if (!empty($outputCompiler)) {
            Storage::disk('local')->delete('.'.$path.'/'.auth()->user()->username.'.'.$type);
            $output = "";

            if (is_array($outputCompiler)) {
                foreach ($outputCompiler as $compiler) {
                    $output .= $compiler;
                }
            } else {
                $output = $outputCompiler;
            }
            return [
                'status' => '2',
                'output' => $output,
            ];
        }

        exec("cd .. && cd storage/app".$path." && ".auth()->user()->username.".exe", $userOutput);
        exec("cd .. && cd storage/app/answers/corrects/".$matter->chapter->language->id."/".$matter->chapter->id." && ".$matter->id.".exe", $correctOutput);

        if ($userOutput===$correctOutput) {
            return [
                'status' => '1',
                'output' => $userOutput,
            ];
        } else {
            return [
                'status' => '0',
                'output' => $userOutput,
            ];
        }
    }

    public static function correctAnswer($matterId, $userAnswer="") {
        $user = auth()->user();

        $point = $user->detail()->first()->point;

        $matter = ModelsMatter::whereId($matterId)->first();
        $study = Study::where('user_id', $user->id)->where('matter_id', $matterId);
        $point = $point + $study->first()->point;

        if ($study->first()->finished=='0') {
            $result = Result::where('user_id', $user->id)->where('date', date('Y-m-d'))->first();

            if (!empty($result)) {
                Result::where('user_id', $user->id)
                        ->where('date', date('Y-m-d'))
                        ->update(['point' => $result->point + $study->first()->point]);
            } else {
                Result::insert([
                    'user_id' => $user->id,
                    'point' => $study->first()->point,
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
                $user->detail()->first()->update([
                    'point' => $point,
                ]);
            }
        }

        $study->update([
                'user_answer' => $userAnswer,
                'updated_at' => date('Y-m-d G:i:s'),
                'finished' => '1',
            ]);

        Matter::checkAnswer($matter, $userAnswer);
    }

    public static function checkNextLevel() {
        $detail = auth()->user()->detail()->first();
        $level = $detail->level()->first();

        return ($level->point - ($level->point_total - $detail->point))/$level->point * 100;
    }

    public static function checkNewStudy($id) {
        $matter = ModelsMatter::whereId($id)->first();
        if (empty(Study::where('user_id', auth()->user()->id)->where('matter_id', $id)->first())) {
            Study::insert([
                'user_id' => auth()->user()->id,
                'matter_id' => $id,
                'user_answer' => "",
                'point' => $matter->difficulty->point,
            ]);
        }
    }
}
