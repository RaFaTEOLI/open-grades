<?php

namespace App\Repositories\Teacher;

interface TeacherRepositoryInterface
{
    public function all();
    public function findById($id);
}
