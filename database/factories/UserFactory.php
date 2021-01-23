<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' =>  $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('password'),
        'api_token' => Str::random(60),
        'email_verified_at' => Carbon::today(),
        'admin' => true,
        'created_at' => Carbon::today(),
    ];
});
