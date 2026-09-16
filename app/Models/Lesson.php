<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'level',
        'type',
        'order',
        'published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    /**
     * @return HasMany<LessonItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(LessonItem::class)->orderBy('order');
    }
}
