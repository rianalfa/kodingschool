<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language',
    ];

    public function chapters() {
        return $this->hasMany(Chapter::class);
    }
}
