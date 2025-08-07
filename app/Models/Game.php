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
}
