<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSection extends Model
{
    protected $fillable = ['section', 'data'];

    protected $casts = ['data' => 'array'];

    public static function getData(string $section): ?array
    {
        return static::where('section', $section)->value('data');
    }
}
