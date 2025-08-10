<?php

namespace App\Console\Commands;

use App\Http\Integrations\ESPN\ESPNConnector;
use App\Http\Integrations\ESPN\Requests\GetWeekScoreboardRequest;
use App\Models\Game;
use App\Models\GameTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchLiveScores extends Command
{
    protected $signature = 'fetch:live-scores {week=1} {season=2025} {--type=2 : Season type (1=preseason, 2=regular, 3=postseason)}';
    protected $description = 'Fetch live scores for games in a specific week and season type';

    public function handle()
    {
        $week = (int) $this->argument('week');
        $season = (int) $this->argument('season');
        $seasonType = (int) $this->option('type');

        $seasonTypeNames = [1 => 'preseason', 2 => 'regular season', 3 => 'postseason'];
        $seasonTypeName = $seasonTypeNames[$seasonType] ?? 'unknown';

        // Log command execution start
        Log::info("FetchLiveScores command started", [
            'week' => $week,
            'season' => $season,
            'season_type' => $seasonType,
            'timestamp' => now()->toISOString(),
            'timezone' => config('app.timezone')
        ]);

        $this->info("Fetching live scores for {$seasonTypeName} Week {$week}, {$season}...");

        $connector = new ESPNConnector();
        
        try {
            // Fetch all games for the week from ESPN scoreboard
            $request = new GetWeekScoreboardRequest($week, $season, $seasonType);
            $response = $connector->send($request);

            if (!$response->successful()) {
                $this->error("Failed to fetch scoreboard data from ESPN");
                return 1;
            }

            $gamesData = $response->dto();
            
            if (empty($gamesData)) {
                $this->warn("No games found in ESPN scoreboard for Week {$week}, {$season}");
                return 1;
            }

            $this->info("Found " . count($gamesData) . " games in ESPN scoreboard");
            $updatedGames = 0;

            foreach ($gamesData as $gameData) {
                try {
                    // Find the game in our database by ESPN ID
                    $game = Game::where('espn_id', $gameData['espn_id'])->first();
                    
                    if (!$game) {
                        $this->warn("Game {$gameData['espn_id']} not found in database, skipping...");
                        continue;
                    }

                    // Update game status
                    $game->update(['status' => $gameData['status']]);

                    // Update team scores
                    DB::transaction(function () use ($game, $gameData) {
                        // Update home team score
                        if ($gameData['home_team']['espn_id']) {
                            GameTeam::where('game_id', $game->id)
                                ->whereHas('team', function ($query) use ($gameData) {
                                    $query->where('espn_id', $gameData['home_team']['espn_id']);
                                })
                                ->update(['score' => $gameData['home_team']['score']]);
                        }

                        // Update away team score  
                        if ($gameData['away_team']['espn_id']) {
                            GameTeam::where('game_id', $game->id)
                                ->whereHas('team', function ($query) use ($gameData) {
                                    $query->where('espn_id', $gameData['away_team']['espn_id']);
                                })
                                ->update(['score' => $gameData['away_team']['score']]);
                        }
                    });

                    $updatedGames++;
                    
                    $this->line("Updated scores for game {$game->espn_id}: {$gameData['away_team']['score']}-{$gameData['home_team']['score']} ({$gameData['status']})");

                    Log::info("Updated game scores", [
                        'game_id' => $game->espn_id,
                        'status' => $gameData['status'],
                        'home_score' => $gameData['home_team']['score'],
                        'away_score' => $gameData['away_team']['score']
                    ]);

                } catch (\Exception $e) {
                    $this->error("Error updating game {$gameData['espn_id']}: " . $e->getMessage());
                    Log::error("Error updating game scores", [
                        'game_id' => $gameData['espn_id'] ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $this->info("✅ Updated scores for {$updatedGames} games");
            
            // Log successful completion
            Log::info("FetchLiveScores command completed successfully", [
                'week' => $week,
                'season' => $season,
                'season_type' => $seasonType,
                'updated_games' => $updatedGames,
                'timestamp' => now()->toISOString()
            ]);
            
            // If games are completed, trigger weekly scoring calculation
            $completedGames = Game::where('week', $week)
                ->where('season', $season)
                ->where('season_type', $seasonType)
                ->where('status', 'completed')
                ->count();
                
            if ($completedGames > 0) {
                $this->info("Found {$completedGames} completed games. Consider running 'calculate:weekly-scores {$week} {$season}'");
            }

        } catch (\Exception $e) {
            $this->error("Error fetching live scores: " . $e->getMessage());
            Log::error("Error in FetchLiveScores command", [
                'week' => $week,
                'season' => $season,
                'season_type' => $seasonType,
                'error' => $e->getMessage()
            ]);
            return 1;
        }

        return 0;
    }
}