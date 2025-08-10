<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\UserPrediction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GamePredictions extends Component
{
    public $games = [];
    public $predictions = [];
    public $tiebreakerPrediction = '';
    public $tiebreakerGame = null;
    public int $currentWeek;
    public int $currentSeasonType;
    public bool $predictionsClosed = false;

    public function mount()
    {
        $this->currentSeasonType = $this->getCurrentSeasonType();
        $this->currentWeek = $this->getCurrentNFLWeek();
        $this->loadGames();
        $this->loadTiebreakerGame();
        $this->loadUserPredictions();
        $this->checkPredictionStatus();
    }

    private function getCurrentNFLWeek(): int
    {
        $now = Carbon::now();

        // Handle preseason separately
        if ($this->currentSeasonType == 1) {
            return $this->getCurrentPreseasonWeek();
        }

        // NFL regular season typically starts first Thursday of September
        // Week 1 starts Thursday, September 4, 2025
        $seasonStart = Carbon::create(2025, 9, 4);

        // If we're before the season starts, show Week 1
        if ($now->lt($seasonStart)) {
            return 1;
        }

        // Calculate weeks since season started
        $weeksSinceStart = $now->diffInWeeks($seasonStart);

        // Each NFL week runs Thursday to Monday
        // If today is Tuesday or Wednesday, we're in the "off week" - show next week
        if ($now->dayOfWeek >= Carbon::TUESDAY && $now->dayOfWeek <= Carbon::WEDNESDAY) {
            $weeksSinceStart++;
        }

        // Cap at 18 weeks (regular season)
        return min($weeksSinceStart + 1, 18);
    }

    private function getCurrentPreseasonWeek(): int
    {
        $now = Carbon::now();

        // Preseason 2025 schedule (approximate)
        $preseasonWeek1Start = Carbon::create(2025, 8, 1);  // August 1
        $preseasonWeek2Start = Carbon::create(2025, 8, 8);  // August 8
        $preseasonWeek3Start = Carbon::create(2025, 8, 15); // August 15
        $preseasonWeek4Start = Carbon::create(2025, 8, 22); // August 22

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

    private function getCurrentSeasonType(): int
    {
        $now = Carbon::now();

        // NFL 2025 season dates (approximate)
        $preseasonStart = Carbon::create(2025, 8, 1);    // August 1st
        $regularSeasonStart = Carbon::create(2025, 9, 4); // September 4th (first Thursday)
        $postseasonStart = Carbon::create(2026, 1, 11);   // January 11th (Wild Card weekend)

        if ($now->lt($preseasonStart)) {
            // Before preseason - show previous year's postseason or current preseason
            return 1; // Default to preseason for testing
        } elseif ($now->gte($preseasonStart) && $now->lt($regularSeasonStart)) {
            return 1; // Preseason
        } elseif ($now->gte($regularSeasonStart) && $now->lt($postseasonStart)) {
            return 2; // Regular season
        } else {
            return 3; // Postseason
        }
    }

    private function checkPredictionStatus()
    {
        // Find the earliest game of the current week
        $earliestGame = collect($this->games)->sortBy('date_time')->first();

        if ($earliestGame) {
            $gameTime = Carbon::parse($earliestGame['date_time']);
            $this->predictionsClosed = Carbon::now()->gte($gameTime);
        }
    }

    // app/Livewire/GamePredictions.php - Update the loadGames method
    public function loadGames()
    {
        $this->games = Game::with(['venue', 'teams', 'gameTeams.team'])
            ->where('week', $this->currentWeek)
            ->where('season', 2025)
            ->where('season_type', $this->currentSeasonType)
            ->orderBy('date_time')
            ->get()
            ->map(function ($game) {
                $homeTeam = $game->teams->where('pivot.is_home', true)->first();
                $awayTeam = $game->teams->where('pivot.is_home', false)->first();
                
                // Get scores from GameTeam relationship
                $homeGameTeam = $game->gameTeams->where('is_home', true)->first();
                $awayGameTeam = $game->gameTeams->where('is_home', false)->first();

                return [
                    'id' => $game->id,
                    'espn_id' => $game->espn_id,
                    'date_time' => $game->date_time,
                    'venue' => $game->venue,
                    'home_team' => $homeTeam ? [
                        'id' => $homeTeam->id,
                        'name' => $homeTeam->name,
                        'abbreviation' => $homeTeam->abbreviation,
                        'primary_color' => $homeTeam->primary_color,
                        'secondary_color' => $homeTeam->secondary_color,
                        'logo_url' => $homeTeam->logo_url,
                        'conference' => $homeTeam->conference,
                        'division' => $homeTeam->division,
                        'score' => $homeGameTeam ? $homeGameTeam->score : null,
                    ] : null,
                    'away_team' => $awayTeam ? [
                        'id' => $awayTeam->id,
                        'name' => $awayTeam->name,
                        'abbreviation' => $awayTeam->abbreviation,
                        'primary_color' => $awayTeam->primary_color,
                        'secondary_color' => $awayTeam->secondary_color,
                        'logo_url' => $awayTeam->logo_url,
                        'conference' => $awayTeam->conference,
                        'division' => $awayTeam->division,
                        'score' => $awayGameTeam ? $awayGameTeam->score : null,
                    ] : null,
                    'status' => $game->status,
                    'can_predict' => Carbon::now()->lt(Carbon::parse($game->date_time)),
                    'is_completed' => in_array($game->status, ['completed', 'final']) && Carbon::now()->gte(Carbon::parse($game->date_time)),
                    'has_scores' => (in_array($game->status, ['completed', 'final', 'in_progress']) && Carbon::now()->gte(Carbon::parse($game->date_time))),
                ];
            })
            ->toArray();
    }

    public function loadTiebreakerGame()
    {
        $this->tiebreakerGame = Game::getTiebreakerGame($this->currentWeek, 2025, $this->currentSeasonType);
    }

    public function loadUserPredictions()
    {
        if (!Auth::check()) return;

        $gameIds = collect($this->games)->pluck('id');

        $userPredictions = UserPrediction::where('user_id', Auth::id())
            ->whereIn('game_id', $gameIds)
            ->get()
            ->keyBy('game_id');

        $this->predictions = $userPredictions->map->predicted_team_id->toArray();

        // Load tiebreaker prediction if tiebreaker game exists
        if ($this->tiebreakerGame) {
            $tiebreakerPrediction = $userPredictions->get($this->tiebreakerGame->id);
            $this->tiebreakerPrediction = $tiebreakerPrediction?->tiebreaker_prediction ?? '';
        }
    }

    public function makePrediction($gameId, $teamId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to make predictions.');
            return;
        }

        // Check if predictions are closed for this specific game
        $game = collect($this->games)->firstWhere('id', $gameId);
        if (!$game || !$game['can_predict']) {
            session()->flash('error', 'Predictions are closed for this game.');
            return;
        }

        UserPrediction::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'game_id' => $gameId,
            ],
            [
                'predicted_team_id' => $teamId,
            ]
        );

        $this->predictions[$gameId] = $teamId;

        // Reload games to update prediction status
        $this->loadGames();

        session()->flash('success', 'Prediction saved!');
    }

    public function saveTiebreakerPrediction()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to make predictions.');
            return;
        }

        if (!$this->tiebreakerGame) {
            session()->flash('error', 'No tiebreaker game found for this week.');
            return;
        }

        // Check if predictions are closed for the tiebreaker game
        if (!$this->tiebreakerGame->date_time || Carbon::now()->gte($this->tiebreakerGame->date_time)) {
            session()->flash('error', 'Tiebreaker predictions are closed.');
            return;
        }

        // Validate the prediction is a positive integer
        if (!is_numeric($this->tiebreakerPrediction) || $this->tiebreakerPrediction < 0) {
            session()->flash('error', 'Please enter a valid total score prediction.');
            return;
        }

        UserPrediction::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'game_id' => $this->tiebreakerGame->id,
            ],
            [
                'tiebreaker_prediction' => (int) $this->tiebreakerPrediction,
            ]
        );

        session()->flash('success', 'Tiebreaker prediction saved!');
    }

    /**
     * Refresh game data for real-time score updates
     */
    public function refreshScores()
    {
        $this->loadGames();
        $this->checkPredictionStatus();
    }

    /**
     * Check if any games are currently in progress to determine if we should poll
     */
    public function hasGamesInProgress()
    {
        $now = Carbon::now();
        
        return collect($this->games)->contains(function ($game) use ($now) {
            $gameTime = Carbon::parse($game['date_time']);
            $gameEndTime = $gameTime->copy()->addHours(4); // Games typically last ~3-4 hours
            
            // Game is in progress if it has started but not ended and not completed
            $gameStarted = $now->gte($gameTime);
            $gameNotEnded = $now->lte($gameEndTime);
            $gameNotCompleted = !in_array($game['status'], ['completed', 'final']);
            
            return $gameStarted && $gameNotEnded && $gameNotCompleted;
        });
    }

    public function render()
    {
        return view('livewire.game-predictions')
            ->layout('components.layouts.app');
    }
}
