<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArabicLetterForm extends Model
{
    protected $fillable = [
        'arabic_letter_id',
        'position',
        'form',
        'example',
        'example_transliteration',
        'example_meaning',
    ];

    /**
     * Get the parent letter.
     *
     * @return BelongsTo<ArabicLetter, $this>
     */
    public function letter(): BelongsTo
    {
        return $this->belongsTo(ArabicLetter::class, 'arabic_letter_id');
    }
}
