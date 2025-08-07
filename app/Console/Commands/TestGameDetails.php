<?php

namespace App\Console\Commands;

use App\Jobs\ProcessGameReference;
use Illuminate\Console\Command;

class TestGameDetails extends Command
{
    protected $signature = 'test:game-details {gameId}';
    protected $description = 'Test fetching game details with DTOs';

    public function handle()
    {
        // Add this at the beginning of the handle method:
        $this->info("Testing database connection...");
        try {
            $count = \App\Models\Team::count();
            $this->info("✅ Database connected. Teams table has {$count} records.");
        } catch (\Exception $e) {
            $this->error("❌ Database connection failed: " . $e->getMessage());
            return;
        }

        $gameId = $this->argument('gameId');

        $this->info("Testing ProcessGameReference job for game ID: {$gameId}");

        // Create a mock reference URL
        $referenceUrl = "http://sports.core.api.espn.com/v2/sports/football/leagues/nfl/events/{$gameId}";

        // Run synchronously to see any errors immediately
        try {
            ProcessGameReference::dispatchSync($referenceUrl);
            $this->info("✅ Job completed successfully!");
        } catch (\Exception $e) {
            $this->error("❌ Job failed: " . $e->getMessage());
            $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
        }
    }
}
