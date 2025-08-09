<?php

namespace App\Livewire;

use App\Models\WeeklyScore;
use Carbon\Carbon;
use Livewire\Component;

class WeeklyLeaderboard extends Component
{
    public int $selectedWeek;
    public int $selectedSeason;
    public $weeklyScores = [];

    public function mount()
    {
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

    public function loadWeeklyScores()
    {
        $this->weeklyScores = WeeklyScore::with('user')
            ->where('week', $this->selectedWeek)
            ->where('season', $this->selectedSeason)
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
