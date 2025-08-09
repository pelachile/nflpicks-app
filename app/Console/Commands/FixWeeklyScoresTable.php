<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixWeeklyScoresTable extends Command
{
    protected $signature = 'db:fix-weekly-scores';
    protected $description = 'Fix weekly_scores table by adding missing columns';

    public function handle()
    {
        $this->info('Fixing weekly_scores table...');
        
        try {
            // Add all missing columns
            $this->info('Adding user_id column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS user_id BIGINT UNSIGNED NOT NULL');
            
            $this->info('Adding week column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS week INTEGER NOT NULL');
            
            $this->info('Adding season column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS season INTEGER NOT NULL');
            
            $this->info('Adding wins column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS wins INTEGER NOT NULL DEFAULT 0');
            
            $this->info('Adding losses column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS losses INTEGER NOT NULL DEFAULT 0');
            
            $this->info('Adding tiebreaker_prediction column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS tiebreaker_prediction INTEGER NULL');
            
            $this->info('Adding actual_tiebreaker_score column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS actual_tiebreaker_score INTEGER NULL');
            
            $this->info('Adding tiebreaker_difference column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS tiebreaker_difference INTEGER NULL');
            
            $this->info('Adding rank column...');
            DB::statement('ALTER TABLE weekly_scores ADD COLUMN IF NOT EXISTS rank INTEGER NULL');
            
            // Add foreign key constraint
            $this->info('Adding foreign key constraint...');
            DB::statement('ALTER TABLE weekly_scores ADD CONSTRAINT IF NOT EXISTS weekly_scores_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
            
            // Add indexes for performance
            $this->info('Adding indexes...');
            DB::statement('CREATE INDEX IF NOT EXISTS weekly_scores_week_season_index ON weekly_scores (week, season)');
            DB::statement('CREATE INDEX IF NOT EXISTS weekly_scores_rank_index ON weekly_scores (rank)');
            
            $this->info('✅ Weekly scores table fixed successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error fixing table: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}