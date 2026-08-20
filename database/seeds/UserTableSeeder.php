<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        
        User::create([
            'role_id' => 1,
            'name' => 'Basant',
            'email' => 'basant@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
