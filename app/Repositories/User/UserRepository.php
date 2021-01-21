<?php

namespace App\Repositories\User;

use App\Http\Controllers\StudentController;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Exception;

class UserRepository implements UserRepositoryInterface
{

    /*
        Get All Active Users
    */
    public function all()
    {
        return User::where('deleted_at', null)
            ->get()
            ->map->format();
    }

    /*
        Get An User By Id
    */
    public function findById($id)
    {
        return User::findOrFail($id)
            ->where('deleted_at', null)
            ->get()
            ->first()
            ->format();
    }

    public function findByUsername($username)
    {
    }

    public function update($userId, $set)
    {
        $user = User::where('id', $userId)->first();

        $user->update($set);
    }

    public function delete($userId)
    {
        $user = User::where('id', $userId)->delete();

        return true;
    }

    public function createType($type, $userId)
    {
        if ($type === 'TEACHER') {
            $this->createTeacher($userId);
        } else if ($type === 'STUDENT') {
            $this->createStudent($userId);
        } else {
            throw new Exception('No type specified');
        }
    }

    public function createStudent($userId)
    {
        $studentController = new StudentController();

        $typeData = [
            "user_id" => $userId,
            "student_number" => $studentController->generateStudentNumber()
        ];

        return Student::create($typeData);
    }

    public function createTeacher($userId)
    {
        $studentController = new StudentController();

        $typeData = [
            "user_id" => $userId,
            "teacher_number" => $studentController->generateStudentNumber()
        ];

        return Teacher::create($typeData);
    }
}
