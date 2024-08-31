<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateDatabase extends Command
{
    protected $signature = 'db:truncate';
    protected $description = 'Truncate all tables in the database';

    public function handle()
    {
        // Get all tables
        $tables = DB::select('SELECT name FROM sqlite_master WHERE type="table"');

        foreach ($tables as $table) {
            $tableName = $table->name;

            // Check if the table exists before truncating
            if (Schema::hasTable($tableName)) {
                DB::table($tableName)->truncate();
                $this->info("Truncated table: $tableName");
            }
        }

        $this->info('All tables truncated successfully!');
    }
}
