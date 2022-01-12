<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Difficulty;
use App\Models\Chapter;
use App\Models\Study;

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
        if ($number == Matter::where('chapter_id', $chapter)->orderBy('number', 'desc')->first()->number) {
            $chapter = Chapter::whereId($chapter)->first();

            if ($chapter->number == Chapter::where('language_id', $chapter->language_id)->orderBy('number', 'desc')->first()->number) {
                return "finished";
            } else {
                $chapter = Chapter::where('language_id', $chapter->language()->first()->id)
                                ->where('number', '>', $chapter->number)
                                ->orderBy('number', 'asc')
                                ->first();

                return Matter::where('chapter_id', $chapter->id)
                            ->orderBy('number', 'asc')
                            ->first();
            }
        } else {
            return Matter::where('number', '>', $number)
                        ->where('chapter_id', $chapter)
                        ->orderBy('number', 'asc')
                        ->first();
        }
    }

    public function difficulty() {
        return $this->belongsTo(Difficulty::class);
    }

    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }

    public function study($userId) {
        return $this->hasMany(Study::class)->where('user_id', $userId)->first();
    }
}
