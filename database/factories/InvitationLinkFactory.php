<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\InvitationLink;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

$factory->define(InvitationLink::class, function (Faker $faker) {
    return [
        "type" => "STUDENT",
        "user_id" => Auth::user()->id,
        "hash" => InvitationLink::generateHash()
    ];
});
