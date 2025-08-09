<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'espn_id',
        'week',
        'season',
        'season_type',
        'date_time',
        'venue_id',
        'status',
        'weather_conditions',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'weather_conditions' => 'array',
    ];

    // Relationships
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function gameTeams(): HasMany
    {
        return $this->hasMany(GameTeam::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'game_teams')
            ->withPivot('is_home', 'score')
            ->withTimestamps();
    }

    // Helper methods to get home/away teams
    public function homeTeam(): BelongsToMany
    {
        return $this->teams()->wherePivot('is_home', true);
    }

    public function awayTeam(): BelongsToMany
    {
        return $this->teams()->wherePivot('is_home', false);
    }

    // Check if this is the Monday Night Football tiebreaker game
    public function isTiebreakerGame(): bool
    {
        // Convert to Central Time to properly identify Monday games
        return $this->date_time->setTimezone('America/Chicago')->dayOfWeek === 1; // Monday
    }

    // Get the tiebreaker game for a specific week
    public static function getTiebreakerGame(int $week, ?int $season = null, ?int $seasonType = null): ?self
    {
        $season = $season ?? now()->year;
        $seasonType = $seasonType ?? 2; // Default to regular season
        
        return self::where('week', $week)
            ->where('season', $season)
            ->where('season_type', $seasonType)
            ->get()
            ->filter(fn($game) => $game->isTiebreakerGame())
            ->first();
    }

    // Calculate total score (home + away)
    public function getTotalScore(): int
    {
        return $this->gameTeams()->sum('score') ?? 0;
    }
}
