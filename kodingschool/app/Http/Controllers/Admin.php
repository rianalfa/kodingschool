<?php

namespace App\Http\Controllers;

use App\Models\Matter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Admin extends Controller
{
    public static function correctAnswer($type, $matterId, $content) {
        $matter = Matter::whereId($matterId)->first();

        $path = "/answers/corrects/".$matter->chapter->language->id.'/'.$matter->chapter->id;
        Storage::disk('local')->put('.'.$path.'.'.$type, $content);

        switch ($type) {
            case "cpp":
                exec("g++ ../storage/app".$path."/".$matter->id.".cpp -O3 -o ../storage/app".$path."/".$matter->id.".exe 2>&1", $outputCompiler);
                break;
        }

        if (!empty($outputCompiler)) {
            Storage::disk('local')->delete('.'.$path.'.'.$type);
            $output = "";

            if (is_array($outputCompiler)) {
                foreach ($outputCompiler as $compiler) {
                    $output += $compiler;
                }
            }
            // $this->emit('swal', 'error', $output);
        }
    }
}
