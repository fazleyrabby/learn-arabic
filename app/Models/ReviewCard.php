<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewCard extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'card_type',
        'card_id',
        'repetitions',
        'interval_days',
        'ease_factor',
        'due_at',
        'last_reviewed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ease_factor' => 'decimal:2',
            'due_at' => 'datetime',
            'last_reviewed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
