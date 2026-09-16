<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordMorphology extends Model
{
    protected $fillable = [
        'quran_word_id',
        'part_of_speech',
        'pattern',
        'form',
        'case',
        'mood',
        'tense',
        'voice',
        'person',
        'gender',
        'number',
        'features_json',
        'source',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'features_json' => 'array',
        ];
    }

    /**
     * Get the word this morphology describes.
     *
     * @return BelongsTo<QuranWord, $this>
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(QuranWord::class, 'quran_word_id');
    }
}
