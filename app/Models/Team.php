<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'espn_id',
        'name',
        'abbreviation',
        'conference',
        'division',
        'primary_color',
        'secondary_color',
        'logo_url',
    ];
    public function gameTeams()
    {
        return $this->hasMany(GameTeam::class);
    }

    public function games()
    {
        return $this->hasManyThrough(Game::class, GameTeam::class);
    }
}
