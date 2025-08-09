<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use App\Models\UserPrediction;
use App\Models\WeeklyScore;
use App\Http\Integrations\ESPN\ESPNConnector;
use App\Http\Integrations\ESPN\Requests\GetGameScoresRequest;
use Illuminate\Support\Facades\Log;

class WeeklyScoringService
{
    public function calculateWeeklyScores(int $week, int $season = null): array
    {
        $season = $season ?? now()->year;
        
        // Get all games for the week
        $games = Game::where('week', $week)
            ->where('season', $season)
            ->with(['gameTeams.team'])
            ->get();

        if ($games->isEmpty()) {
            return ['message' => 'No games found for this week'];
        }

        // Update scores from ESPN API
        $this->updateGameScores($games);

        // Get all users who made predictions this week
        $gameIds = $games->pluck('id');
        $users = User::whereHas('predictions', function ($query) use ($gameIds) {
            $query->whereIn('game_id', $gameIds);
        })->with(['predictions' => function ($query) use ($gameIds) {
            $query->whereIn('game_id', $gameIds);
        }])->get();

        $weeklyResults = [];

        foreach ($users as $user) {
            $score = $this->calculateUserWeeklyScore($user, $games, $week, $season);
            $weeklyResults[] = $score;
        }

        // Sort by wins (descending), then by tiebreaker accuracy (ascending)
        usort($weeklyResults, function ($a, $b) {
            if ($a['wins'] === $b['wins']) {
                // If wins are tied, sort by tiebreaker accuracy (lower difference is better)
                return $a['tiebreaker_difference'] <=> $b['tiebreaker_difference'];
            }
            return $b['wins'] <=> $a['wins']; // Higher wins first
        });

        // Store results in database
        $this->storeWeeklyResults($weeklyResults, $week, $season);

        return $weeklyResults;
    }

    private function updateGameScores($games): void
    {
        $connector = new ESPNConnector();

        foreach ($games as $game) {
            try {
                $request = new GetGameScoresRequest($game->espn_id);
                $response = $connector->send($request);

                if ($response->successful()) {
                    $scoreData = $response->dto();
                    
                    // Update game teams with scores
                    foreach ($game->gameTeams as $gameTeam) {
                        $teamEspnId = $gameTeam->team->espn_id;
                        
                        if ($gameTeam->is_home && $teamEspnId == $scoreData['home_team']['espn_id']) {
                            $gameTeam->update(['score' => $scoreData['home_team']['score']]);
                        } elseif (!$gameTeam->is_home && $teamEspnId == $scoreData['away_team']['espn_id']) {
                            $gameTeam->update(['score' => $scoreData['away_team']['score']]);
                        }
                    }

                    // Update game status
                    $game->update(['status' => $scoreData['status']]);
                }
            } catch (\Exception $e) {
                Log::error("Failed to update scores for game {$game->espn_id}: " . $e->getMessage());
            }
        }
    }

    private function calculateUserWeeklyScore(User $user, $games, int $week, int $season): array
    {
        $wins = 0;
        $losses = 0;
        $tiebreakerDifference = null;
        $tiebreakerPrediction = null;
        $actualTiebreakerScore = null;

        foreach ($games as $game) {
            $prediction = $user->predictions->where('game_id', $game->id)->first();
            
            if (!$prediction) {
                $losses++; // No prediction counts as a loss
                continue;
            }

            // Check if this is the tiebreaker game
            if ($game->isTiebreakerGame() && $prediction->tiebreaker_prediction) {
                $tiebreakerPrediction = $prediction->tiebreaker_prediction;
                $actualTiebreakerScore = $game->getTotalScore();
                $tiebreakerDifference = abs($tiebreakerPrediction - $actualTiebreakerScore);
            }

            // Check if prediction is correct
            $winningTeam = $this->getWinningTeam($game);
            
            if ($winningTeam && $prediction->predicted_team_id === $winningTeam->id) {
                $wins++;
            } else {
                $losses++;
            }
        }

        return [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'week' => $week,
            'season' => $season,
            'wins' => $wins,
            'losses' => $losses,
            'tiebreaker_prediction' => $tiebreakerPrediction,
            'actual_tiebreaker_score' => $actualTiebreakerScore,
            'tiebreaker_difference' => $tiebreakerDifference ?? 999, // High number if no tiebreaker
        ];
    }

    private function getWinningTeam($game)
    {
        $homeTeam = $game->gameTeams->where('is_home', true)->first();
        $awayTeam = $game->gameTeams->where('is_home', false)->first();

        if (!$homeTeam || !$awayTeam || is_null($homeTeam->score) || is_null($awayTeam->score)) {
            return null; // Game not finished
        }

        if ($homeTeam->score > $awayTeam->score) {
            return $homeTeam->team;
        } elseif ($awayTeam->score > $homeTeam->score) {
            return $awayTeam->team;
        }

        return null; // Tie game (rare in NFL)
    }

    private function storeWeeklyResults(array $results, int $week, int $season): void
    {
        foreach ($results as $index => $result) {
            WeeklyScore::updateOrCreate(
                [
                    'user_id' => $result['user_id'],
                    'week' => $week,
                    'season' => $season,
                ],
                [
                    'wins' => $result['wins'],
                    'losses' => $result['losses'],
                    'tiebreaker_prediction' => $result['tiebreaker_prediction'],
                    'actual_tiebreaker_score' => $result['actual_tiebreaker_score'],
                    'tiebreaker_difference' => $result['tiebreaker_difference'],
                    'rank' => $index + 1, // 1-based ranking
                ]
            );
        }
    }
}