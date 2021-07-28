<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\StudentsResponsible;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(StudentsResponsible::class, function (Faker $faker) {
    $student = factory(User::class)->create();
    $studentRole = Role::where("name", "student")->first();
    $student->attachRole($studentRole);

    $responsible = factory(User::class)->create();
    $responsibleRole = Role::where("name", "responsible")->first();
    $responsible->attachRole($responsibleRole);

    return [
        "student_id" => $student->id,
        "responsible_id" => $responsible->id,
    ];
});
