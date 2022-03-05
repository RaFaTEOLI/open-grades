<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Grade;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Warning;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

$factory->define(Warning::class, function (Faker $faker) {
    $class = factory(Subject::class)->create();
    $student = factory(Grade::class)->create();
    $description = $faker->sentence(2);

    $studentRole = Role::where("name", "student")->first();
    $student->attachRole($studentRole);

    return [
        "class_id" => $class->id,
        "student_id" => $student->id,
        "description" => $description,
        "reporter_id" => Auth::user()->id
    ];
});
