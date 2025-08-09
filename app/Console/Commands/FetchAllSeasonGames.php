<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FetchAllSeasonGames extends Command
{
    protected $signature = 'fetch:all-season-games {season=2025}';
    protected $description = 'Fetch all preseason, regular season, and postseason games for a complete season';

    public function handle()
    {
        $season = (int) $this->argument('season');
        $totalGames = 0;

        $this->info("🏈 Fetching complete {$season} NFL season schedule...");

        // Preseason (4 weeks)
        $this->info("\n📅 Fetching Preseason...");
        for ($week = 1; $week <= 4; $week++) {
            $this->line("  Fetching Preseason Week {$week}...");
            $exitCode = Artisan::call('fetch:season-schedule', [
                'week' => $week,
                'season' => $season,
                '--type' => 1
            ]);

            if ($exitCode === 0) {
                $this->line("  ✅ Preseason Week {$week} scheduled for processing");
            } else {
                $this->warn("  ⚠️  Issue with Preseason Week {$week}");
            }
        }

        // Regular Season (18 weeks)
        $this->info("\n📅 Fetching Regular Season...");
        for ($week = 1; $week <= 18; $week++) {
            $this->line("  Fetching Regular Season Week {$week}...");
            $exitCode = Artisan::call('fetch:season-schedule', [
                'week' => $week,
                'season' => $season,
                '--type' => 2
            ]);

            if ($exitCode === 0) {
                $this->line("  ✅ Regular Season Week {$week} scheduled for processing");
            } else {
                $this->warn("  ⚠️  Issue with Regular Season Week {$week}");
            }
        }

        // Postseason (4 weeks typically)
        $this->info("\n📅 Fetching Postseason...");
        for ($week = 1; $week <= 4; $week++) {
            $this->line("  Fetching Postseason Week {$week}...");
            $exitCode = Artisan::call('fetch:season-schedule', [
                'week' => $week,
                'season' => $season,
                '--type' => 3
            ]);

            if ($exitCode === 0) {
                $this->line("  ✅ Postseason Week {$week} scheduled for processing");
            } else {
                $this->warn("  ⚠️  Issue with Postseason Week {$week}");
            }
        }

        $this->info("\n🎉 All {$season} season games have been queued for processing!");
        $this->info("📋 Next steps:");
        $this->line("  1. Run: php artisan queue:work --stop-when-empty");
        $this->line("  2. Run: php artisan fetch:team-data");
        $this->line("  3. Run: php artisan queue:work --stop-when-empty");
        $this->info("🤖 Then let schedule:run handle live scores automatically!");

        return 0;
    }
}