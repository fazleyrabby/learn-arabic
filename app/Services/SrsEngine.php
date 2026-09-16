<?php

namespace App\Services;

use App\Models\ReviewCard;
use Carbon\Carbon;

class SrsEngine
{
    /**
     * Process a review attempt for a card.
     *
     * @param  int  $quality  Rating from 1 (Again), 2 (Hard), 3 (Good), 4 (Easy)
     */
    public function review(ReviewCard $card, int $quality): ReviewCard
    {
        $quality = max(1, min(4, $quality));
        $now = Carbon::now();

        if ($quality < 3) {
            // Failed recall: reset repetition count
            $card->repetitions = 0;
            $card->interval_days = 1;
        } else {
            // Successful recall
            if ($card->repetitions === 0) {
                $card->interval_days = 1;
            } elseif ($card->repetitions === 1) {
                $card->interval_days = 3;
            } else {
                $multiplier = (float) $card->ease_factor;
                if ($quality === 4) {
                    $multiplier *= 1.3;
                }
                $card->interval_days = (int) round($card->interval_days * $multiplier);
            }

            $card->repetitions += 1;
        }

        // Adjust ease factor (SuperMemo SM-2 formula scaled for 1-4 input)
        // Convert 1..4 scale to 2..5 scale for standard SM-2 formula
        $smQuality = $quality + 1;
        $easeAdjustment = 0.1 - (5 - $smQuality) * (0.08 + (5 - $smQuality) * 0.02);
        $newEase = max(1.30, (float) $card->ease_factor + $easeAdjustment);

        $card->ease_factor = round($newEase, 2);
        $card->last_reviewed_at = $now;
        $card->due_at = $now->copy()->addDays($card->interval_days);
        $card->save();

        return $card;
    }
}
