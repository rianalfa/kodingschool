<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Difficulty;
use App\Models\Chapter;
use App\Models\Study;
use Illuminate\Support\Facades\DB;

class Matter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'matter',
        'hint',
        'answer',
        'chapter_id',
        'difficulty_id',
        'instruction',
        'question',
        'number',
    ];

    public static function next($number, $chapter) {
        $matter = [];
        if ($number == Matter::where('chapter_id', $chapter)->orderBy('number', 'desc')->first()->number) {
            $chapter = Chapter::whereId($chapter)->first();

            if ($chapter->number == Chapter::where('language_id', $chapter->language_id)->orderBy('number', 'desc')->first()->number) {
                $matter[0] = "finished";
                $matter[1] = Matter::where('chapter_id', $chapter->id)->where('number', $number)->first();
            } else {
                $chapter = Chapter::where('language_id', $chapter->language_id)
                                ->where('number', '>', $chapter->number)
                                ->orderBy('number', 'asc')
                                ->first();

                $matter[0] = "noFinished";
                $matter[1] = Matter::where('chapter_id', $chapter->id)
                            ->orderBy('number', 'asc')
                            ->first();
            }
        } else {
            $matter[0] = "notFinished";
            $matter[1] = Matter::where('number', '>', $number)
                        ->where('chapter_id', $chapter)
                        ->orderBy('number', 'asc')
                        ->first();
        }
        return $matter;
    }

    public static function previous($number, $chapter) {
        if ($number == Matter::where('chapter_id', $chapter)->orderBy('number', 'asc')->first()->number) {
            $chapter = Chapter::whereId($chapter)->first();

            if ($chapter->number == Chapter::where('language_id', $chapter->language_id)->orderBy('number', 'asc')->first()->number) {
                $matter = Matter::where('chapter_id', $chapter->id)->where('number', $number)->first();
            } else {
                $chapter = Chapter::where('language_id', $chapter->language_id)
                                ->where('number', '<', $chapter->number)
                                ->orderBy('number', 'desc')
                                ->first();

                $matter = DB::table('matters')
                            ->join('studies', 'matters.id', '=', 'studies.matter_id')
                            ->where('matters.chapter_id', $chapter->id)
                            ->orderBy('matters.number', 'desc')
                            ->first();

                if (!empty($matter)) {
                    $matter = Matter::whereId($matter->matter_id)->first();
                } else {
                    $matter = Matter::where('chapter_id', $chapter->id)->where('number', $number)->first();
                }
            }
        } else {
            $matter = Matter::where('number', '<', $number)
                            ->where('chapter_id', $chapter)
                            ->orderBy('number', 'desc')
                            ->first();
        }
        return $matter;
    }

    public function difficulty() {
        return $this->belongsTo(Difficulty::class);
    }

    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }

    public function studies() {
        return $this->hasMany(Study::class);
    }

    public function study($userId) {
        return $this->hasOne(Study::class)->where('user_id', $userId)->first();
    }

    public function benchmarks() {
        return $this->hasMany(Benchmark::class);
    }
}
