<?php

namespace App\Console\Commands;

use App\Livewire\GamePredictions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FetchCurrentWeekScores extends Command
{
    protected $signature = 'fetch:current-week-scores';
    protected $description = 'Automatically fetch live scores for the current NFL week and season type';

    public function handle()
    {
        // Use the same logic as GamePredictions to determine current week/season type
        $component = new GamePredictions();
        $component->mount();
        
        $currentWeek = $component->currentWeek;
        $currentSeasonType = $component->currentSeasonType;
        $season = 2025;

        $seasonTypes = [1 => 'preseason', 2 => 'regular season', 3 => 'postseason'];
        $seasonTypeName = $seasonTypes[$currentSeasonType] ?? 'unknown';

        $this->info("🏈 Fetching live scores for {$seasonTypeName} Week {$currentWeek}, {$season}");

        $exitCode = Artisan::call('fetch:live-scores', [
            'week' => $currentWeek,
            'season' => $season,
            '--type' => $currentSeasonType
        ]);

        if ($exitCode === 0) {
            $this->info("✅ Successfully fetched current week scores");
            
            // Trigger weekly scoring calculation if it's Monday (after games are done)
            if (now()->dayOfWeek === 1) { // Monday
                $this->info("🧮 Calculating weekly scores...");
                Artisan::call('calculate:weekly-scores', [
                    'week' => $currentWeek,
                    'season' => $season
                ]);
            }
        } else {
            $this->error("❌ Failed to fetch current week scores");
        }

        return $exitCode;
    }
}