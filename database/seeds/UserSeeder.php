<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'api_token' => Str::random(60),
            'email_verified_at' => Carbon::today(),
            'admin' => true,
            'created_at' => Carbon::today(),
        ]);
    }
}
