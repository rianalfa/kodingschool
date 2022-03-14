<?php

namespace App\Http\Controllers;

use App\Models\Matter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Admin extends Controller
{
    public static function correctAnswer($type, $matterId, $content) {
        $matter = Matter::whereId($matterId)->first();

        if ($type=="java") {
            $c1 = strpos($content, 'class');
            $c2 = strpos($content, '{');

            $content = substr($content, 0, $c1+5)." java".$matterId." ".substr($content, $c2);
        }

        $path = "/answers/corrects/".$matter->chapter->language->id.'/'.$matter->chapter->id;
        Storage::disk('local')->put('.'.$path.'/'.$matter->id.'.'.$type, $content);

        switch ($type) {
            case "cpp":
                exec("cd .. && cd storage/app".$path." && g++ ".$matter->id.".cpp -O3 -o ".$matter->id.".exe 2>&1", $outputCompiler);
                break;
            case "pas":
                exec("cd .. && cd storage/app".$path." && fpc ".$matter->id.".pas 2>&1", $outputCompiler);
                if (!empty(array_search("Linking ".$matter->id.".exe", $outputCompiler))) $outputCompiler="";
                break;
            case "java":
                exec("cd .. && cd storage/app".$path." && javac ".$matter->id.".java", $outputCompiler);
                break;
        }

        $output = "";
        if (!empty($outputCompiler)) {
            Storage::disk('local')->delete('.'.$path.'.'.$type);

            if (is_array($outputCompiler)) {
                foreach ($outputCompiler as $compiler) {
                    $output .= $compiler;
                }
            } else {
                $output = $outputCompiler;
            }
        }

        return $output;
    }
}
