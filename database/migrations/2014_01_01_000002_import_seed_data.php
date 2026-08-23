<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ImportSeedData extends Migration
{
    /**
     * Tables to seed with production data.
     * Order matters for foreign key constraints.
     */
    private $tables = [
        'states',
        'cities',
        'roles',
        'modules',
        'permissions',
        'role_module_permissions',
        'organizers',
        'payment_method',
        'settings',
        'tax_rates',
        'users',
        'company',       // empty but included for completeness
        'configuration', // empty but included for completeness
    ];

    /**
     * Run the migrations.
     * Imports seed data for master/config tables from the SQL dump.
     *
     * @return void
     */
    public function up()
    {
        $sqlPath = database_path('seed_data.sql');

        if (!file_exists($sqlPath)) {
            throw new \RuntimeException("Seed data file not found: {$sqlPath}");
        }

        $sql = file_get_contents($sqlPath);

        // Split into individual statements
        $statements = $this->splitSqlStatements($sql);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && stripos($statement, 'INSERT INTO') === 0) {
                DB::unprepared($statement . ';');
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach (array_reverse($this->tables) as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Split SQL content into individual statements
     */
    private function splitSqlStatements($sql)
    {
        $statements = [];
        $current = '';
        $lines = explode("\n", $sql);

        foreach ($lines as $line) {
            $trimmed = trim($line);

            // Skip empty lines and comments
            if (empty($trimmed) || strpos($trimmed, '--') === 0) {
                continue;
            }

            $current .= $line . "\n";

            // Check if statement ends with semicolon
            if (substr($trimmed, -1) === ';') {
                $statements[] = rtrim($current, ";\n\r ");
                $current = '';
            }
        }

        if (!empty(trim($current))) {
            $statements[] = rtrim($current, ";\n\r ");
        }

        return $statements;
    }
}
