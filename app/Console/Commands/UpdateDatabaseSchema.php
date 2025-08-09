<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateDatabaseSchema extends Command
{
    protected $signature = 'db:update-schema';
    protected $description = 'Update database schema for tiebreaker feature';

    public function handle()
    {
        $this->info('Updating database schema...');
        
        try {
            // Add tiebreaker_prediction to user_predictions table
            DB::statement('ALTER TABLE user_predictions ADD COLUMN IF NOT EXISTS tiebreaker_prediction INTEGER NULL');
            $this->info('Added tiebreaker_prediction column to user_predictions table');
            
            // Add season_type to games table  
            DB::statement('ALTER TABLE games ADD COLUMN IF NOT EXISTS season_type INTEGER NOT NULL DEFAULT 2');
            $this->info('Added season_type column to games table');
            
            // Update the migrations table to mark these as run
            DB::table('migrations')->insert([
                ['migration' => '2025_08_09_051124_add_tiebreaker_prediction_to_user_predictions_table', 'batch' => 1],
                ['migration' => '2025_08_09_065826_add_season_type_to_games_table', 'batch' => 1],
            ]);
            
            $this->info('✅ Schema updated successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error updating schema: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}