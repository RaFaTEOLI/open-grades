<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Classes;
use App\Models\Grade;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use App\Models\Year;
use Faker\Generator as Faker;

$factory->define(Classes::class, function (Faker $faker) {
    $year = factory(Year::class)->create();
    $subject = factory(Subject::class)->create();
    $grade = factory(Grade::class)->create();
    $teacher = factory(User::class)->create();

    $teacherRole = Role::where("name", "teacher")->first();
    $teacher->attachRole($teacherRole);

    return [
        "year_id" => $year->id,
        "subject_id" => $subject->id,
        "grade_id" => $grade->id,
        "user_id" => $teacher->id,
    ];
});
