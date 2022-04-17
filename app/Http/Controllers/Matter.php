<?php

namespace App\Http\Controllers;

use App\Models\Benchmark;
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

    public static function checkAnswer($matter, $content, $isEq=false) {
        $type = $matter->chapter->language->type;

        $path = "/answers/users/".$matter->chapter->language->id.'/'.$matter->chapter->id."/".$matter->id;
        Storage::disk('local')->put('.'.$path.'/'.auth()->user()->username.'.'.$type, $content);

        $userOutput = "";
        $correctOutput = "";

        switch ($type) {
            case "cpp":
                exec("cd .. && cd storage/app".$path." && g++ ".auth()->user()->username.".cpp -O3 -o ".auth()->user()->username.".exe  2>&1", $outputCompiler);
                if (empty($outputCompiler)) {
                    exec("cd .. && cd storage/app".$path." && cppcheck ".auth()->user()->username.".cpp 2>&1", $outputChecker);
                }

                if (empty($outputCompiler)) {
                    $outputCompiler = Matter::checkBenchmark($matter->id, $content);
                }

                exec("cd .. && cd storage/app".$path." && ".auth()->user()->username.".exe", $userOutput);
                exec("cd .. && cd storage/app/answers/corrects/".$matter->chapter->language->id."/".$matter->chapter->id." && ".$matter->id.".exe", $correctOutput);
                break;
            case "pas":
                exec("cd .. && cd storage/app".$path." && fpc ".auth()->user()->username.".pas 2>&1", $outputCompiler);
                if (!empty(array_search("Linking ".auth()->user()->username.".exe", $outputCompiler))) $outputCompiler="";
                if (empty($outputCompiler)) {
                    exec("cd .. && cd storage/app".$path." && palcmd ".auth()->user()->username.".pas 2>&1", $outputChecker);
                }

                if (empty($outputCompiler)) {
                    $outputCompiler = Matter::checkBenchmark($matter->id, $content);
                }

                exec("cd .. && cd storage/app".$path." && ".auth()->user()->username.".exe", $userOutput);
                exec("cd .. && cd storage/app/answers/corrects/".$matter->chapter->language->id."/".$matter->chapter->id." && ".$matter->id.".exe", $correctOutput);
                break;
            case "java":
                exec("cd .. && cd storage/app".$path." && javac ".auth()->user()->username.".java 2>&1", $outputCompiler);
                if (empty($outputCompiler)) {
                    exec("cd .. && cd storage/app/answers/users/".$matter->chapter->language->id." && java -jar checkstyle-9.3-all.jar -c /google_checks.xml ".$matter->chapter->id."/".$matter->id."/".auth()->user()->username.".java 2>&1", $outputChecker);
                }

                if (empty($outputCompiler)) {
                    $outputCompiler = Matter::checkBenchmark($matter->id, $content);
                }

                exec("cd .. && cd storage/app".$path." && java ".auth()->user()->username, $userOutput);
                exec("cd .. && cd storage/app/answers/corrects/".$matter->chapter->language->id."/".$matter->chapter->id." && java java".$matter->id, $correctOutput);
                break;
            case "php":
                exec("cd .. && cd storage/app".$path." && psalm ".auth()->user()->username.".php 2>&1", $outputChecker);

                if (empty($outputCompiler)) {
                    $outputCompiler = Matter::checkBenchmark($matter->id, $content);
                }

                exec("cd .. && cd storage/app".$path." && php ".auth()->user()->username.".php 2>&1", $userOutput);
                exec("cd .. && cd storage/app/answers/corrects/".$matter->chapter->language->id."/".$matter->chapter->id." && php ".$matter->id.".php", $correctOutput);
                break;
            case "js":
                exec("cd .. && cd storage/app".$path." && npx eslint ".auth()->user()->username.".js 2>&1", $outputCompiler);
                if (!empty($outputCompiler) && is_array($outputCompiler)) {
                    $outputCompiler = array_slice($outputCompiler, 1);
                    $outputCompiler[0] = auth()->user()->username.".js";
                }

                if (empty($outputCompiler)) {
                    $outputCompiler = Matter::checkBenchmark($matter->id, $content);
                }

                exec("cd .. && cd storage/app".$path." && node ".auth()->user()->username.".js", $userOutput);
                exec("cd .. && cd storage/app/answers/corrects/".$matter->chapter->language->id."/".$matter->chapter->id." && node ".$matter->id.".js", $correctOutput);
                break;
            case "html":
                $outputCompiler = Matter::checkBenchmark($matter->id, $content);

                $userOutput = "true";
                $correctOutput = $isEq==true ? "true" : "false";
                break;
        }

        if (!empty($outputCompiler)) {
            $output = "";

            if (is_array($outputCompiler)) {
                foreach ($outputCompiler as $compiler) {
                    $output .= $compiler."\r\n";
                }
            } else {
                $output = $outputCompiler;
            }
            return [
                'status' => '2',
                'output' => $output,
            ];
        } else {
            $output = "";

            if (is_array($userOutput)) {
                foreach ($userOutput as $compiler) {
                    $output .= $compiler."\r\n";
                }
            } else {
                $output = $userOutput;
            }

            if ($userOutput===$correctOutput) {
                return [
                    'status' => '1',
                    'output' => $output,
                ];
            } else {
                return [
                    'status' => '0',
                    'output' => $output,
                ];
            }
        }
    }

    public static function checkBenchmark($matterId, $answer) {
        $benchmarks = Benchmark::where('matter_id', $matterId)->get();
        foreach ($benchmarks as $benchmark) {
            $count = substr_count($answer, $benchmark->keyword);
            if ($count!=(int)$benchmark->number) {
                return "Pastikan kamu menggunakan keyword '".$benchmark->keyword."' ya";
            }
        }
        return "";
    }

    public static function correctAnswer($matterId, $userAnswer="") {
        $user = auth()->user();

        $point = $user->detail()->first()->point;

        $matter = ModelsMatter::whereId($matterId)->first();
        $study = Study::where('user_id', $user->id)->where('matter_id', $matterId);
        $point = $point + $study->first()->point;
        $levelUp="no";

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
                $level = ($level->id!=100) ? $level->id+1 : 100;

                $user->detail()->update([
                    'point' => $point,
                    'level_id' => $level,
                ]);

                $levelUp = "yes";
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

        return $levelUp;
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
