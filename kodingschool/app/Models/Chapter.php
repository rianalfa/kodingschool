<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Models\Matter;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language_id',
        'number',
        'description',
    ];

    public function matters() {
        return $this->hasMany(Matter::class);
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }
}
