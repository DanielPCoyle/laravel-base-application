<?php

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
        //
        DB::table('users')->insert(
        	[
        		"name" => "Marty McFly",
        		"email" => "test@email.com",
        		"password"=> bcrypt("password")
        	]
        );
    }
}
