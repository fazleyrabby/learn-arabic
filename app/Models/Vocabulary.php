<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vocabulary extends Model
{
    protected $fillable = [
        'arabic',
        'normalized_arabic',
        'lemma',
        'root_id',
        'transliteration',
        'meaning_en',
        'meaning_bn',
        'part_of_speech',
        'frequency',
        'difficulty',
        'audio_url',
    ];

    /**
     * Get the root for this vocabulary word.
     *
     * @return BelongsTo<Root, $this>
     */
    public function root(): BelongsTo
    {
        return $this->belongsTo(Root::class, 'root_id');
    }

    /**
     * Get the Quran occurrences of this word.
     *
     * @return HasMany<VocabularyOccurrence, $this>
     */
    public function occurrences(): HasMany
    {
        return $this->hasMany(VocabularyOccurrence::class);
    }
}
