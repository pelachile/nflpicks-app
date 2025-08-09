<?php

namespace App\Livewire;

use App\Models\WeeklyScore;
use Carbon\Carbon;
use Livewire\Component;

class WeeklyLeaderboard extends Component
{
    public int $selectedWeek;
    public int $selectedSeason;
    public int $selectedSeasonType;
    public $weeklyScores = [];

    public function mount()
    {
        $this->selectedSeasonType = $this->getCurrentSeasonType();
        $this->selectedWeek = $this->getCurrentNFLWeek();
        $this->selectedSeason = now()->year;
        $this->loadWeeklyScores();
    }

    public function updatedSelectedWeek()
    {
        $this->loadWeeklyScores();
    }

    public function updatedSelectedSeason()
    {
        $this->loadWeeklyScores();
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
        
        // Handle preseason separately
        if ($this->selectedSeasonType == 1) {
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

    public function loadWeeklyScores()
    {
        $this->weeklyScores = WeeklyScore::with('user')
            ->where('week', $this->selectedWeek)
            ->where('season', $this->selectedSeason)
            ->where('season_type', $this->selectedSeasonType)
            ->orderBy('rank')
            ->get()
            ->map(function ($score) {
                return [
                    'rank' => $score->rank,
                    'user_name' => $score->user->name,
                    'wins' => $score->wins,
                    'losses' => $score->losses,
                    'record' => $score->wins . '–' . $score->losses,
                    'tiebreaker_prediction' => $score->tiebreaker_prediction,
                    'actual_tiebreaker_score' => $score->actual_tiebreaker_score,
                    'tiebreaker_difference' => $score->tiebreaker_difference,
                    'had_tiebreaker' => $score->tiebreaker_prediction !== null,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.weekly-leaderboard')
            ->layout('components.layouts.app');
    }
}
