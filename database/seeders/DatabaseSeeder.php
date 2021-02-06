<?php

use Database\Seeders\LaravelEntrustSeeder;
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
        $this->call(UserSeeder::class);
        $this->call(ConfigurationSeeder::class);
        $this->call(LaravelEntrustSeeder::class);
    }
}
