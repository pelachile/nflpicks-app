<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Team;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DebugPredictionsData extends Command
{
    protected $signature = 'debug:predictions';
    protected $description = 'Debug predictions UI data';

    public function handle()
    {
        $this->info('Debugging Predictions Data...');
        
        // Check basic counts
        $this->info("\nDatabase counts:");
        $this->info("Teams: " . Team::count());
        $this->info("Venues: " . Venue::count());
        $this->info("Total games: " . Game::count());
        
        // Check current week detection
        $now = Carbon::now();
        $this->info("\nDate/Time logic:");
        $this->info("Server time: " . $now);
        $this->info("Timezone: " . config('app.timezone'));
        
        // Determine current week/season type
        $preseasonStart = Carbon::create(2025, 8, 1);
        $regularSeasonStart = Carbon::create(2025, 9, 4);
        $currentSeasonType = 1; // Preseason
        
        if ($now->gte($regularSeasonStart)) {
            $currentSeasonType = 2;
        }
        
        $currentWeek = 2; // Based on date Aug 9
        if ($now->gte(Carbon::create(2025, 8, 15))) {
            $currentWeek = 3;
        }
        
        $this->info("Current season type: " . $currentSeasonType . " (1=pre, 2=reg, 3=post)");
        $this->info("Current week: " . $currentWeek);
        
        // Check games for current week
        $games = Game::with(['venue', 'teams', 'gameTeams.team'])
            ->where('week', $currentWeek)
            ->where('season', 2025)
            ->where('season_type', $currentSeasonType)
            ->get();
            
        $this->info("\nGames for Week {$currentWeek} (season_type={$currentSeasonType}): " . $games->count());
        
        // Sample first 3 games
        foreach ($games->take(3) as $game) {
            $this->info("\nGame ID: " . $game->id . " (ESPN: " . $game->espn_id . ")");
            $this->info("Date: " . $game->date_time);
            $this->info("Venue: " . ($game->venue ? $game->venue->name : "NO VENUE"));
            
            $homeTeam = $game->teams->where('pivot.is_home', true)->first();
            $awayTeam = $game->teams->where('pivot.is_home', false)->first();
            
            $this->info("Home: " . ($homeTeam ? $homeTeam->name . " (ID: " . $homeTeam->id . ")" : "NO HOME TEAM"));
            $this->info("Away: " . ($awayTeam ? $awayTeam->name . " (ID: " . $awayTeam->id . ")" : "NO AWAY TEAM"));
            
            // Check gameTeams relationship
            $homeGameTeam = $game->gameTeams->where('is_home', true)->first();
            $awayGameTeam = $game->gameTeams->where('is_home', false)->first();
            
            $this->info("GameTeam Home: " . ($homeGameTeam && $homeGameTeam->team ? $homeGameTeam->team->name : "NO GAMETEAM HOME"));
            $this->info("GameTeam Away: " . ($awayGameTeam && $awayGameTeam->team ? $awayGameTeam->team->name : "NO GAMETEAM AWAY"));
        }
        
        // Check for any games without teams
        $gamesWithoutTeams = Game::whereDoesntHave('teams')
            ->where('season', 2025)
            ->count();
        $this->info("\nGames without teams: " . $gamesWithoutTeams);
        
        // Check for duplicate team associations
        $this->info("\nChecking for data issues...");
        foreach ($games->take(1) as $game) {
            $teamCount = $game->teams()->count();
            $gameTeamCount = $game->gameTeams()->count();
            $this->info("Sample game has {$teamCount} teams via pivot, {$gameTeamCount} via gameTeams");
        }
        
        return 0;
    }
}