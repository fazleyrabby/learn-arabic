<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuranWord extends Model
{
    protected $fillable = [
        'quran_verse_id',
        'position',
        'text_ar',
        'normalized_text',
        'lemma',
        'root_id',
        'translation',
        'translation_bn',
        'transliteration',
        'audio_url',
    ];

    /**
     * Get the verse this word belongs to.
     *
     * @return BelongsTo<QuranVerse, $this>
     */
    public function verse(): BelongsTo
    {
        return $this->belongsTo(QuranVerse::class, 'quran_verse_id');
    }

    /**
     * Get the root for this word.
     *
     * @return BelongsTo<Root, $this>
     */
    public function root(): BelongsTo
    {
        return $this->belongsTo(Root::class, 'root_id');
    }

    /**
     * Get the morphology analysis for this word.
     *
     * @return HasOne<WordMorphology, $this>
     */
    public function morphology(): HasOne
    {
        return $this->hasOne(WordMorphology::class);
    }
}
