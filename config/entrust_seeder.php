<?php

use Illuminate\Support\Str;

return [
    "role_structure" => [
        "admin" => [
            "users" => "c,r,u,d",
            "admin" => "c,r,u,d",
            "profile" => "r,d",
            "teachers" => "c,r,u,d",
            "students" => "c,r,u,d",
            "classes" => "c,r,u,d",
        ],
        "teacher" => [
            "profile" => "r,u",
            "teachers" => "r",
            "students" => "r",
            "classes" => "c,r,u,d",
        ],
        "student" => [
            "profile" => "r,u",
            "teachers" => "r",
            "students" => "r",
            "classes" => "r",
        ],
        "responsible" => [
            "profile" => "r,u",
            "teachers" => "r",
            "students" => "r",
            "classes" => "r",
        ],
    ],
    "user_roles" => [
        "admin" => [
            [
                "name" => "Admin",
                "email" => "opengrades@gmail.com",
                "password" => "password",
                "email_verified_at" => "2021-02-05 22:29:50",
            ],
        ],
    ],
    "permissions_map" => [
        "c" => "create",
        "r" => "read",
        "u" => "update",
        "d" => "delete",
    ],
];
