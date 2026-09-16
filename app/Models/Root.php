<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Root extends Model
{
    protected $fillable = [
        'root_ar',
        'root_latin',
        'meaning',
    ];

    /**
     * Get words sharing this root.
     *
     * @return HasMany<QuranWord, $this>
     */
    public function quranWords(): HasMany
    {
        return $this->hasMany(QuranWord::class);
    }

    /**
     * Get vocabulary items sharing this root.
     *
     * @return HasMany<Vocabulary, $this>
     */
    public function vocabularies(): HasMany
    {
        return $this->hasMany(Vocabulary::class);
    }
}
