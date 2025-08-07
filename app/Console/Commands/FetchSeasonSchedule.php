<?php

namespace App\Console\Commands;

use App\Http\Integrations\ESPN\ESPNConnector;
use App\Http\Integrations\ESPN\Requests\GetWeekGamesRequest;
use App\Jobs\ProcessGameReference;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FetchSeasonSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:season-schedule {week=1} {season=2025}';
    protected $description = 'Fetch the 2025 NFL season schedule';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $season = (int) $this->argument('season');
        $week = (int) $this->argument('week');

        $this->info('Fetching NFL {$season} season schedule');

        $connector = new ESPNConnector();
        $request = new GetWeekGamesRequest(2025, 2, 2);

        // Debug: Show the full URL being called
        $fullUrl = $connector->resolveBaseUrl().$request->resolveEndpoint();
        $queryParams = http_build_query($request->query()->all());
        $this->info("🌐 Full URL: {$fullUrl}?{$queryParams}");

        try {
            $response = $connector->send($request);

            $this->info("📊 Response Status: ".$response->status());
            $this->info("📝 Response Headers:");
            foreach ($response->headers() as $key => $value) {
                $this->line("   {$key}: ".(is_array($value) ? implode(', ', $value) : $value));
            }

            if ($response->successful()) {
                $data = $response->json();

                $this->info('✅ Successfully fetched {$season} season schedule');
                $this->info("Total games: ".$data['count']);
                $this->info("First few game references");

                foreach (array_slice($data['items'], 0, 3) as $index => $item) {
                    $this->line(" ".($index + 1).". ".$item['$ref']);
                }
                try {
                    $filename = "espn_week_{$week}_schedule.json";

                    // Use Storage facade and check if it worked
                    $success = Storage::disk('local')->put($filename,
                        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

                    if (isset($data['items']) && count($data['items']) > 0) {
                        $this->info("Dispatching jobs for " . count($data['items']) . " games...");

                        foreach ($data['items'] as $gameRef) {
                            ProcessGameReference::dispatch($gameRef['$ref']);
                        }

                        $this->info("✅ All game processing jobs dispatched for Week {$week}!");
                        $this->info("Run 'php artisan queue:work' to process them.");
                    }

                    if ($success) {
                        $fullPath = Storage::disk('local')->path($filename);
                        $this->info("📄 Raw response saved to: {$fullPath}");

                        // Verify the file exists
                        if (Storage::disk('local')->exists($filename)) {
                            $size = Storage::disk('local')->size($filename);
                            $this->info("✅ File confirmed exists ({$size} bytes)");
                        } else {
                            $this->error("❌ File was not created successfully");
                        }
                    } else {
                        $this->error("❌ Storage::put() returned false");
                    }

                } catch (\Exception $e) {
                    $this->error("❌ Storage error: ".$e->getMessage());
                }
            } else {
                $this->error("❌ Failed to fetch {$season} season schedule. HTTP status code: {$response->status()}");
            }
        } catch (\Exception $e) {
            $this->error("❌ Error: ".$e->getMessage());
        }
    }
}
