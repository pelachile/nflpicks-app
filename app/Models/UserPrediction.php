<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPrediction extends Model
{

    protected $fillable = [
        'user_id',
        'game_id',
        'predicted_team_id',
        'confidence_level',
        'tiebreaker_prediction',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function predictedTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'predicted_team_id');
    }
}
