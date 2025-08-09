<?php

namespace App\Console\Commands;

use App\Http\Integrations\ESPN\ESPNConnector;
use App\Http\Integrations\ESPN\Requests\GetWeekScheduleRequest;
use App\Jobs\ProcessGameReference;
use Illuminate\Console\Command;

class FetchWeekData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:week-data {week} {season?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch game data for a specific week and season';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $week = $this->argument('week');
        $season = $this->argument('season') ?? 2024;

        $this->info("Fetching data for Week {$week}, {$season} season...");

        try {
            $connector = new ESPNConnector();
            $request = new GetWeekScheduleRequest($week, $season);
            $response = $connector->send($request);

            if (!$response->successful()) {
                $this->error("Failed to fetch schedule data");
                return 1;
            }

            $scheduleData = $response->json();
            
            if (!isset($scheduleData['items'])) {
                $this->error("No games found in response");
                return 1;
            }

            $games = $scheduleData['items'];
            $this->info("Found " . count($games) . " games for Week {$week}");

            foreach ($games as $game) {
                $this->line("Processing game: " . ($game['name'] ?? 'Unknown'));
                
                // Dispatch job to process each game
                ProcessGameReference::dispatch($game['$ref']);
            }

            $this->info("✅ All games dispatched to queue");
            $this->info("Run 'php artisan queue:work --stop-when-empty' to process them");

        } catch (\Exception $e) {
            $this->error("Error fetching week data: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
