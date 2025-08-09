<?php

namespace App\Console\Commands;

use App\Services\WeeklyScoringService;
use Illuminate\Console\Command;

class CalculateWeeklyScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:calculate {week?} {season?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate weekly scores and rankings with tiebreaker logic';

    /**
     * Execute the console command.
     */
    public function handle(WeeklyScoringService $scoringService)
    {
        $week = $this->argument('week') ?? $this->getCurrentNFLWeek();
        $season = $this->argument('season') ?? now()->year;

        $this->info("Calculating scores for Week {$week}, {$season} season...");

        $results = $scoringService->calculateWeeklyScores($week, $season);

        if (isset($results['message'])) {
            $this->warn($results['message']);
            return;
        }

        $this->info("✅ Calculated scores for " . count($results) . " users");

        // Display results
        $headers = ['Rank', 'User', 'Wins', 'Losses', 'Tiebreaker Pred.', 'Actual Score', 'Difference'];
        $tableData = [];

        foreach ($results as $index => $result) {
            $tableData[] = [
                $index + 1,
                $result['user_name'],
                $result['wins'],
                $result['losses'],
                $result['tiebreaker_prediction'] ?: 'N/A',
                $result['actual_tiebreaker_score'] ?: 'N/A',
                $result['tiebreaker_difference'] === 999 ? 'N/A' : $result['tiebreaker_difference'],
            ];
        }

        $this->table($headers, $tableData);
    }

    private function getCurrentNFLWeek(): int
    {
        // Use same logic as GamePredictions component
        $now = \Carbon\Carbon::now();
        $seasonStart = \Carbon\Carbon::create(2025, 9, 4);

        if ($now->lt($seasonStart)) {
            return 1;
        }

        $weeksSinceStart = $now->diffInWeeks($seasonStart);

        if ($now->dayOfWeek >= \Carbon\Carbon::TUESDAY && $now->dayOfWeek <= \Carbon\Carbon::WEDNESDAY) {
            $weeksSinceStart++;
        }

        return min($weeksSinceStart + 1, 18);
    }
}
