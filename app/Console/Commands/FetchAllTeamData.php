<?php

namespace App\Console\Commands;

use App\Jobs\FetchTeamDetails;
use App\Models\Team;
use Illuminate\Console\Command;

class FetchAllTeamData extends Command
{
    protected $signature = 'fetch:team-data';
    protected $description = 'Fetch real team data from ESPN API for all teams';

    public function handle()
    {
        $this->info('Fetching team data from ESPN API...');

        // Get all unique ESPN team IDs from our database
        $teamIds = Team::pluck('espn_id')->unique();

        $this->info("Found {$teamIds->count()} teams to update");

        foreach ($teamIds as $teamId) {
            FetchTeamDetails::dispatch($teamId);
            $this->line("Dispatched job for team ID: {$teamId}");
        }

        $this->info('✅ All team data fetch jobs dispatched!');
        $this->info('Run "php artisan queue:work" to process them.');
    }
}
