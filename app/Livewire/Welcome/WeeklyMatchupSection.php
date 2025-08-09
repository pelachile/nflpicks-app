<?php

namespace App\Livewire\Welcome;

use App\Models\Game;
use App\Models\Team;
use Carbon\Carbon;
use Livewire\Component;

class WeeklyMatchupSection extends Component
{
    public $currentWeek;
    public $featuredGames = [];

    public function mount()
    {
        $this->currentWeek = $this->getCurrentNFLWeek();
        $this->loadFeaturedGames();
    }

    private function getCurrentNFLWeek(): int
    {
        $now = Carbon::now();
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

    private function loadFeaturedGames()
    {
        // First, try to get a Dallas game
        $dallasTeam = Team::where('abbreviation', 'DAL')->first();
        $dallasGame = null;

        if ($dallasTeam) {
            $dallasGame = Game::with(['teams'])
                ->where('week', $this->currentWeek)
                ->where('season', 2025)
                ->whereHas('teams', function ($query) use ($dallasTeam) {
                    $query->where('team_id', $dallasTeam->id);
                })
                ->first();
        }

        // Get other games (excluding Dallas game if found)
        $otherGamesQuery = Game::with(['teams'])
            ->where('week', $this->currentWeek)
            ->where('season', 2025)
            ->orderBy('date_time');

        if ($dallasGame) {
            $otherGamesQuery->where('id', '!=', $dallasGame->id);
        }

        $otherGames = $otherGamesQuery->take(2)->get();

        // Combine games - Dallas first if it exists
        $allGames = collect();
        if ($dallasGame) {
            $allGames->push($dallasGame);
        }
        $allGames = $allGames->concat($otherGames)->take(3);

        $this->featuredGames = $allGames->map(function ($game) {
            $homeTeam = $game->teams->where('pivot.is_home', true)->first();
            $awayTeam = $game->teams->where('pivot.is_home', false)->first();

            return [
                'id' => $game->id,
                'home_team' => $homeTeam,
                'away_team' => $awayTeam,
                'date_time' => $game->date_time,
                'venue' => $game->venue,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.welcome.weekly-matchup-section');
    }
}
