<?php

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;

class CheckTeamData extends Command
{
    protected $signature = 'check:team-data';
    protected $description = 'Check team data integrity';

    public function handle()
    {
        $this->info('Checking Team Data...');
        
        // Sample some teams
        $teams = Team::orderBy('id')->limit(5)->get();
        
        $this->info("\nFirst 5 teams:");
        foreach ($teams as $team) {
            $this->info("ID: {$team->id}");
            $this->info("ESPN ID: {$team->espn_id}");
            $this->info("Name: {$team->name}");
            $this->info("Abbreviation: " . ($team->abbreviation ?: 'NULL'));
            $this->info("Logo: " . ($team->logo_url ? 'YES' : 'NO'));
            $this->info("---");
        }
        
        // Check for placeholder names
        $placeholderTeams = Team::where('name', 'LIKE', 'Team%')
            ->orWhereNull('abbreviation')
            ->orWhereNull('logo_url')
            ->count();
            
        $this->info("\nTeams with placeholder data: {$placeholderTeams}");
        
        // Check specific teams
        $bills = Team::where('name', 'LIKE', '%Bills%')->first();
        if ($bills) {
            $this->info("\nFound Bills: {$bills->name} (ESPN ID: {$bills->espn_id})");
        } else {
            $this->warn("Bills not found!");
        }
        
        return 0;
    }
}