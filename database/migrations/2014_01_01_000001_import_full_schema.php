<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ImportFullSchema extends Migration
{
    /**
     * Run the migrations.
     * Imports the full database schema from the SQL dump.
     *
     * @return void
     */
    public function up()
    {
        $sqlPath = database_path('schema.sql');

        if (!file_exists($sqlPath)) {
            throw new \RuntimeException("Schema file not found: {$sqlPath}");
        }

        $sql = file_get_contents($sqlPath);

        // Remove the header/footer SET statements that are already handled by Laravel
        $sql = preg_replace('/^SET SQL_MODE.*$/m', '', $sql);
        $sql = preg_replace('/^START TRANSACTION.*$/m', '', $sql);
        $sql = preg_replace('/^SET time_zone.*$/m', '', $sql);
        $sql = preg_replace('/^COMMIT;.*$/m', '', $sql);
        $sql = preg_replace('/^\/\*!40101.*$/m', '', $sql);

        // Split by semicolons and execute each statement
        // We need to handle multi-line statements properly
        $statements = $this->splitSqlStatements($sql);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && !$this->isComment($statement)) {
                // Skip migrations table statements since Laravel manages it
                if (preg_match('/(CREATE|ALTER|DROP)\s+TABLE\s+`migrations`/i', $statement)) {
                    continue;
                }
                try {
                    DB::unprepared($statement . ';');
                } catch (\Exception $e) {
                    // Skip if table already exists
                    if (strpos($e->getMessage(), 'already exists') === false) {
                        throw $e;
                    }
                }
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
        $tables = [
            'visitor_logs', 'video_gallery', 'venues', 'users', 'transactions',
            'ticket_type', 'tax_rates', 'sub_venues', 'states', 'settings',
            'sessions', 'role_module_permissions', 'roles', 'pincodes',
            'photo_gallery', 'photo_content', 'permissions', 'payment_method',
            'payment_logs', 'password_resets', 'organizers', 'modules',
            'migrations', 'layout_details', 'layouts', 'general_feedback',
            'fc', 'failed_jobs', 'event_ticket_lists', 'event_tickets',
            'event_show_time', 'event_show_schedule', 'event_seat',
            'event_schedule_list', 'event_schedule', 'events', 'customer_cart',
            'customers', 'coupons_category', 'coupons', 'configuration',
            'company', 'cities', 'cart', 'cancelled_bookings',
            'booking_platform', 'booking_payments', 'booking_details', 'bookings'
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::unprepared("DROP TABLE IF EXISTS `{$table}`;");
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

    /**
     * Check if a string is just a SQL comment
     */
    private function isComment($sql)
    {
        $sql = trim($sql);
        return strpos($sql, '--') === 0;
    }
}
