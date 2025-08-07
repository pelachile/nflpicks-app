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
    public int $currentWeek;
    public bool $predictionsClosed = false;

    public function mount()
    {
        $this->currentWeek = $this->getCurrentNFLWeek();
        $this->loadGames();
        $this->loadUserPredictions();
        $this->checkPredictionStatus();
    }

    private function getCurrentNFLWeek(): int
    {
        $now = Carbon::now();

        // NFL season typically starts first Thursday of September
        // Week 1 starts Thursday, September 4, 2025
        $seasonStart = Carbon::create(2025, 9, 4); // Adjust this date as needed

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

    private function checkPredictionStatus()
    {
        // Find the earliest game of the current week
        $earliestGame = collect($this->games)->sortBy('date_time')->first();

        if ($earliestGame) {
            $gameTime = Carbon::parse($earliestGame['date_time']);
            $this->predictionsClosed = Carbon::now()->gte($gameTime);
        }
    }

    public function loadGames()
    {
        $this->games = Game::with(['venue', 'teams'])
            ->where('week', $this->currentWeek)
            ->where('season', 2025)
            ->orderBy('date_time')
            ->get()
            ->map(function ($game) {
                return [
                    'id' => $game->id,
                    'espn_id' => $game->espn_id,
                    'date_time' => $game->date_time,
                    'venue' => $game->venue,
                    'home_team' => $game->teams->where('pivot.is_home', true)->first(),
                    'away_team' => $game->teams->where('pivot.is_home', false)->first(),
                    'status' => $game->status,
                    'can_predict' => Carbon::now()->lt(Carbon::parse($game->date_time)),
                ];
            })
            ->toArray();
    }

    public function loadUserPredictions()
    {
        if (!Auth::check()) return;

        $gameIds = collect($this->games)->pluck('id');

        $this->predictions = UserPrediction::where('user_id', Auth::id())
            ->whereIn('game_id', $gameIds)
            ->get()
            ->keyBy('game_id')
            ->map->predicted_team_id
            ->toArray();
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

    public function render()
    {
        return view('livewire.game-predictions')
            ->layout('components.layouts.app');
    }
}
