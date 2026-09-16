<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuranSurah extends Model
{
    protected $fillable = [
        'number',
        'name_ar',
        'name_latin',
        'name_english',
        'revelation_type',
        'verse_count',
    ];

    /**
     * Get verses of the surah.
     *
     * @return HasMany<QuranVerse, $this>
     */
    public function verses(): HasMany
    {
        return $this->hasMany(QuranVerse::class)->orderBy('verse_number');
    }
}
