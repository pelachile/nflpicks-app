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
            // Check if columns exist before adding (PostgreSQL compatible)
            $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'weekly_scores'");
            $existingColumns = collect($columns)->pluck('column_name')->toArray();
            
            // Add missing columns (PostgreSQL syntax)
            if (!in_array('user_id', $existingColumns)) {
                $this->info('Adding user_id column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN user_id BIGINT NOT NULL');
            }
            
            if (!in_array('week', $existingColumns)) {
                $this->info('Adding week column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN week INTEGER NOT NULL');
            }
            
            if (!in_array('season', $existingColumns)) {
                $this->info('Adding season column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN season INTEGER NOT NULL');
            }
            
            if (!in_array('wins', $existingColumns)) {
                $this->info('Adding wins column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN wins INTEGER NOT NULL DEFAULT 0');
            }
            
            if (!in_array('losses', $existingColumns)) {
                $this->info('Adding losses column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN losses INTEGER NOT NULL DEFAULT 0');
            }
            
            if (!in_array('tiebreaker_prediction', $existingColumns)) {
                $this->info('Adding tiebreaker_prediction column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN tiebreaker_prediction INTEGER');
            }
            
            if (!in_array('actual_tiebreaker_score', $existingColumns)) {
                $this->info('Adding actual_tiebreaker_score column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN actual_tiebreaker_score INTEGER');
            }
            
            if (!in_array('tiebreaker_difference', $existingColumns)) {
                $this->info('Adding tiebreaker_difference column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN tiebreaker_difference INTEGER');
            }
            
            if (!in_array('rank', $existingColumns)) {
                $this->info('Adding rank column...');
                DB::statement('ALTER TABLE weekly_scores ADD COLUMN rank INTEGER');
            }
            
            // Add foreign key constraint (check if it doesn't exist)
            $this->info('Adding foreign key constraint...');
            try {
                DB::statement('ALTER TABLE weekly_scores ADD CONSTRAINT weekly_scores_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
            } catch (\Exception $e) {
                // Constraint might already exist
                $this->info('Foreign key constraint may already exist');
            }
            
            // Add indexes for performance
            $this->info('Adding indexes...');
            try {
                DB::statement('CREATE INDEX weekly_scores_week_season_index ON weekly_scores (week, season)');
            } catch (\Exception $e) {
                // Index might already exist
            }
            
            try {
                DB::statement('CREATE INDEX weekly_scores_rank_index ON weekly_scores (rank)');
            } catch (\Exception $e) {
                // Index might already exist
            }
            
            $this->info('✅ Weekly scores table fixed successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error fixing table: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}