<?php

namespace App\Console\Commands;

use App\Jobs\FetchTeamDetails;
use Illuminate\Console\Command;

class TestSingleTeam extends Command
{
    protected $signature = 'test:team {teamId}';
    protected $description = 'Test fetching data for a single team';

    // Update TestSingleTeam command
    public function handle()
    {
        $teamId = $this->argument('teamId');
        $this->info("Testing team ID: {$teamId}");

        // Check if team exists first
        $team = \App\Models\Team::where('espn_id', $teamId)->first();
        if (!$team) {
            $this->error("❌ Team with ESPN ID {$teamId} not found in database");
            $this->info("Available ESPN IDs: " . \App\Models\Team::pluck('espn_id')->implode(', '));
            return;
        }

        $this->info("Found team: {$team->name}");

        try {
            FetchTeamDetails::dispatchSync($teamId);

            // Check if it was updated
            $updatedTeam = $team->fresh();
            $this->info("Team after update: {$updatedTeam->name}");
            $this->info("✅ Success!");
        } catch (\Exception $e) {
            $this->error("❌ Failed: " . $e->getMessage());
        }
    }
}
