<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocabularyOccurrence extends Model
{
    protected $fillable = [
        'vocabulary_id',
        'quran_surah_id',
        'quran_verse_id',
        'quran_word_id',
    ];

    /**
     * @return BelongsTo<Vocabulary, $this>
     */
    public function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class);
    }

    /**
     * @return BelongsTo<QuranSurah, $this>
     */
    public function surah(): BelongsTo
    {
        return $this->belongsTo(QuranSurah::class, 'quran_surah_id');
    }

    /**
     * @return BelongsTo<QuranVerse, $this>
     */
    public function verse(): BelongsTo
    {
        return $this->belongsTo(QuranVerse::class, 'quran_verse_id');
    }

    /**
     * @return BelongsTo<QuranWord, $this>
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(QuranWord::class, 'quran_word_id');
    }
}
