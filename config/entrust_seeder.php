<?php

return [
    "role_structure" => [
        "admin" => [
            "users" => "c,r,u,d",
            "admin" => "c,r,u,d",
            "profile" => "r,d",
            "teachers" => "c,r,u,d",
            "students" => "c,r,u,d",
            "classes" => "c,r,u,d",
            "roles" => "c,r,u,d",
            "permissions" => "c,r,u,d",
            "invitation" => "c,r,u,d",
            "configuration" => "c,r,u,d",
            "dashboard" => "c,r,u,d",
            "evaluation-types" => "c,r,u,d",
            "grades" => "c,r,u,d",
            "student-classes" => "c,r,u,d",
            "subjects" => "c,r,u,d",
            "years" => "c,r,u,d",
            "warnings" => "c,r,u,d",
            "statements" => "c,r,u,d",
        ],
        "teacher" => [
            "profile" => "r,u",
            "evaluation-types" => "r",
            "teachers" => "r",
            "students" => "r",
            "classes" => "c,r,u,d",
            "grades" => "r",
            "student-classes" => "r",
            "warnings" => "c,r,u,d",
        ],
        "student" => [
            "profile" => "r,u",
            "teachers" => "r",
            "students" => "r",
            "classes" => "r",
            "student-classes" => "c, r",
            "warnings" => "r",
        ],
        "responsible" => [
            "profile" => "r,u",
            "teachers" => "r",
            "students" => "r",
            "classes" => "r",
            "student-classes" => "c, r",
            "warnings" => "r",
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
