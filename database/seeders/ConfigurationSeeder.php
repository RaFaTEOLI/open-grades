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
            ],
            [
                'name' => 'school-monthly-price',
                'value' => '0',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'use-email-notification',
                'value' => '1',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'use-telegram-notification',
                'value' => '1',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'use-whatsapp-notification',
                'value' => '1',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'max-enroll-subjects',
                'value' => '12',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'can-student-enroll',
                'value' => '1',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
