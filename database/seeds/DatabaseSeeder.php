<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production')
        {
            exit('Sorry you are in production');
        }
        
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ModulePermissionTabelSeeder::class);
    }
}
