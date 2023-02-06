<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // To-Do - need to check is users already exists and do not truncate table
        // DB::table('users')->truncate();
    	
        DB::table('users')->insert([
            'locale_id' => '1',
            'is_registered' => '1',
            'is_admin' => '1',
            'email' => "admin@kvibl.com",
            'password' => bcrypt("1234"),
        ]);

        DB::table('users')->insert([
            'locale_id' => '1',
            'is_registered' => '1',
            'is_admin' => '1',
            'email' => "id@kvibl.com",
            'password' => bcrypt("1234"),
        ]);
        
        DB::table('users')->insert([
            'locale_id' => '1',
            'is_registered' => '1',
            'is_admin' => '1',
            'email' => "ym@kvibl.com",
            'password' => bcrypt("1234"),
        ]);
    }
}
