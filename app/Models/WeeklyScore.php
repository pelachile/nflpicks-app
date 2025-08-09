<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyScore extends Model
{
    protected $fillable = [
        'user_id',
        'week',
        'season',
        'season_type',
        'wins',
        'losses',
        'tiebreaker_prediction',
        'actual_tiebreaker_score',
        'tiebreaker_difference',
        'rank',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
