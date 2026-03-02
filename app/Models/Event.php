<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_type',
        'badge_text',
        'badge_style',
        'event_date',
        'event_time',
        'location',
        'registration_url',
        'status',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'event_date'  => 'date',
        'is_featured' => 'boolean',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = static::uniqueSlug($event->title);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            static::where('slug', $slug)
                  ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                  ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
