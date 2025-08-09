<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\UserPrediction;
use App\Models\WeeklyScore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $currentWeek;
    public $currentSeasonType;
    public $userStats = [];
    public $upcomingGames = [];
    public $recentScores = [];
    public $leaderboardPreview = [];

    public function mount()
    {
        $this->currentSeasonType = $this->getCurrentSeasonType();
        $this->currentWeek = $this->getCurrentNFLWeek();
        
        $this->loadUserStats();
        $this->loadUpcomingGames();
        $this->loadRecentScores();
        $this->loadLeaderboardPreview();
    }

    private function getCurrentSeasonType(): int
    {
        $now = Carbon::now();
        
        $preseasonStart = Carbon::create(2025, 8, 1);
        $regularSeasonStart = Carbon::create(2025, 9, 4);
        $postseasonStart = Carbon::create(2026, 1, 11);
        
        if ($now->gte($preseasonStart) && $now->lt($regularSeasonStart)) {
            return 1; // Preseason
        } elseif ($now->gte($regularSeasonStart) && $now->lt($postseasonStart)) {
            return 2; // Regular season
        } else {
            return 3; // Postseason
        }
    }

    private function getCurrentNFLWeek(): int
    {
        $now = Carbon::now();
        
        if ($this->currentSeasonType == 1) {
            return $this->getCurrentPreseasonWeek();
        }
        
        $seasonStart = Carbon::create(2025, 9, 4);
        if ($now->lt($seasonStart)) {
            return 1;
        }
        
        $weeksSinceStart = $now->diffInWeeks($seasonStart);
        if ($now->dayOfWeek >= Carbon::TUESDAY && $now->dayOfWeek <= Carbon::WEDNESDAY) {
            $weeksSinceStart++;
        }
        
        return min($weeksSinceStart + 1, 18);
    }
    
    private function getCurrentPreseasonWeek(): int
    {
        $now = Carbon::now();
        
        $preseasonWeek1Start = Carbon::create(2025, 8, 1);
        $preseasonWeek2Start = Carbon::create(2025, 8, 8);
        $preseasonWeek3Start = Carbon::create(2025, 8, 15);
        $preseasonWeek4Start = Carbon::create(2025, 8, 22);
        
        if ($now->gte($preseasonWeek4Start)) {
            return 4;
        } elseif ($now->gte($preseasonWeek3Start)) {
            return 3;
        } elseif ($now->gte($preseasonWeek2Start)) {
            return 2;
        } else {
            return 1;
        }
    }

    private function loadUserStats()
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        
        // Get current week predictions
        $currentWeekGames = Game::where('week', $this->currentWeek)
            ->where('season', 2025)
            ->where('season_type', $this->currentSeasonType)
            ->pluck('id');
            
        $predictionsCount = UserPrediction::where('user_id', $userId)
            ->whereIn('game_id', $currentWeekGames)
            ->count();
            
        $totalGames = $currentWeekGames->count();
        
        // Get season stats
        $allPredictions = UserPrediction::where('user_id', $userId)
            ->whereHas('game', function ($query) {
                $query->where('season', 2025)
                    ->where('status', 'completed');
            })
            ->with('game.gameTeams')
            ->get();
            
        $correctPredictions = 0;
        foreach ($allPredictions as $prediction) {
            $game = $prediction->game;
            $winningTeam = $game->gameTeams->sortByDesc('score')->first();
            if ($winningTeam && $winningTeam->team_id == $prediction->predicted_team_id) {
                $correctPredictions++;
            }
        }
        
        // Get latest weekly score
        $latestScore = WeeklyScore::where('user_id', $userId)
            ->where('season', 2025)
            ->orderBy('week', 'desc')
            ->first();
        
        $this->userStats = [
            'predictions_this_week' => $predictionsCount,
            'total_games_this_week' => $totalGames,
            'season_correct' => $correctPredictions,
            'season_total' => $allPredictions->count(),
            'season_percentage' => $allPredictions->count() > 0 
                ? round(($correctPredictions / $allPredictions->count()) * 100, 1) 
                : 0,
            'latest_week_rank' => $latestScore?->rank,
            'latest_week_record' => $latestScore ? "{$latestScore->wins}-{$latestScore->losses}" : null,
        ];
    }

    private function loadUpcomingGames()
    {
        $this->upcomingGames = Game::with(['teams', 'venue'])
            ->where('week', $this->currentWeek)
            ->where('season', 2025)
            ->where('season_type', $this->currentSeasonType)
            ->where('date_time', '>', Carbon::now())
            ->orderBy('date_time')
            ->limit(5)
            ->get()
            ->map(function ($game) {
                $homeTeam = $game->teams->where('pivot.is_home', true)->first();
                $awayTeam = $game->teams->where('pivot.is_home', false)->first();
                
                return [
                    'id' => $game->id,
                    'date_time' => $game->date_time,
                    'home_team' => $homeTeam,
                    'away_team' => $awayTeam,
                    'venue' => $game->venue,
                ];
            });
    }

    private function loadRecentScores()
    {
        $this->recentScores = Game::with(['teams', 'gameTeams'])
            ->where('season', 2025)
            ->whereIn('status', ['completed', 'final'])
            ->orderBy('date_time', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($game) {
                $homeTeam = $game->teams->where('pivot.is_home', true)->first();
                $awayTeam = $game->teams->where('pivot.is_home', false)->first();
                $homeScore = $game->gameTeams->where('is_home', true)->first()?->score ?? 0;
                $awayScore = $game->gameTeams->where('is_home', false)->first()?->score ?? 0;
                
                return [
                    'id' => $game->id,
                    'date_time' => $game->date_time,
                    'home_team' => $homeTeam,
                    'away_team' => $awayTeam,
                    'home_score' => $homeScore,
                    'away_score' => $awayScore,
                    'week' => $game->week,
                ];
            });
    }

    private function loadLeaderboardPreview()
    {
        // Get the most recent week with scores
        $latestWeek = WeeklyScore::where('season', 2025)
            ->max('week') ?? $this->currentWeek;
            
        $this->leaderboardPreview = WeeklyScore::with('user')
            ->where('week', $latestWeek)
            ->where('season', 2025)
            ->orderBy('rank')
            ->limit(5)
            ->get()
            ->map(function ($score) {
                return [
                    'rank' => $score->rank,
                    'user_name' => $score->user->name,
                    'wins' => $score->wins,
                    'losses' => $score->losses,
                ];
            });
    }

    public function render()
    {
        $seasonTypeNames = [
            1 => 'Preseason',
            2 => 'Regular Season',
            3 => 'Postseason'
        ];
        
        $currentSeasonTypeName = $seasonTypeNames[$this->currentSeasonType] ?? 'Unknown';
        
        return view('livewire.dashboard', [
            'currentSeasonTypeName' => $currentSeasonTypeName,
        ])->layout('components.layouts.app');
    }
}