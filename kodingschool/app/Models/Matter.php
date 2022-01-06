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

    public static function next($id, $chapter) {
        return Matter::query()
                    ->orderBy('id', 'asc')
                    ->where('id', '>', $id)
                    ->where('chapter_id', $chapter)
                    ->first();
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
