<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateWeeklyScoresTable extends Command
{
    protected $signature = 'db:update-weekly-scores';
    protected $description = 'Add season_type to weekly_scores table';

    public function handle()
    {
        $this->info('Adding season_type to weekly_scores table...');
        
        try {
            // Add season_type to weekly_scores table  
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS season_type INTEGER NOT NULL DEFAULT 2');
            $this->info('Added season_type column to weekly_scores table');
            
            $this->info('✅ Weekly scores table updated successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error updating schema: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}