<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Classes;
use App\Models\Role;
use App\Models\StudentsClasses;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(StudentsClasses::class, function (Faker $faker) {
    $student = factory(User::class)->create();
    $class = factory(Classes::class)->create();

    $studentRole = Role::where("name", "student")->first();
    $student->attachRole($studentRole);

    return [
        "user_id" => $student->id,
        "class_id" => $class->id,
    ];
});
