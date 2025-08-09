<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabase extends Command
{
    protected $signature = 'db:reset-tables';
    protected $description = 'Reset database tables without migrate:fresh';

    public function handle()
    {
        $this->info('Resetting database tables...');
        
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Drop all tables
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        
        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_{$dbName}"} ?? $table->tables_in_{$dbName} ?? null;
            if ($tableName) {
                Schema::dropIfExists($tableName);
                $this->info("Dropped table: {$tableName}");
            }
        }
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
        
        $this->info('All tables dropped. Now run: php artisan migrate');
        
        return 0;
    }
}