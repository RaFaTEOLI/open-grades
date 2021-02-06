<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuration')->insert([
            [
                'name' =>  'school-year-division',
                'value' => '4',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'max-grade',
                'value' => '10',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'point-average',
                'value' => '5',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
