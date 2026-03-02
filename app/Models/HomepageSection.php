<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = ['section', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get a section's data by key, or return null if not saved yet.
     */
    public static function getData(string $section): ?array
    {
        return static::where('section', $section)->value('data');
    }
}
