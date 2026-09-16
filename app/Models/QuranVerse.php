<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuranVerse extends Model
{
    protected $fillable = [
        'quran_surah_id',
        'verse_number',
        'text_ar',
        'translation',
        'translation_bn',
        'transliteration',
        'audio_url',
    ];

    /**
     * Get the parent surah.
     *
     * @return BelongsTo<QuranSurah, $this>
     */
    public function surah(): BelongsTo
    {
        return $this->belongsTo(QuranSurah::class, 'quran_surah_id');
    }

    /**
     * Get the individual words in the verse.
     *
     * @return HasMany<QuranWord, $this>
     */
    public function words(): HasMany
    {
        return $this->hasMany(QuranWord::class)->orderBy('position');
    }
}
