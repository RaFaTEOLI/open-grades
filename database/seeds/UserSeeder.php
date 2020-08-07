<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' =>  'admin',
            'email' => 'opengrades@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::today(),
            'admin' => true,
            'created_at' => Carbon::today(),
        ]);
    }
}
