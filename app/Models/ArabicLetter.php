<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArabicLetter extends Model
{
    protected $fillable = [
        'character',
        'name_ar',
        'name_latin',
        'name_bn',
        'transliteration',
        'transliteration_bn',
        'order',
        'description',
        'description_bn',
        'makhraj',
        'makhraj_bn',
        'audio_url',
    ];

    /**
     * Get the positional forms of the letter.
     *
     * @return HasMany<ArabicLetterForm, $this>
     */
    public function forms(): HasMany
    {
        return $this->hasMany(ArabicLetterForm::class);
    }
}
