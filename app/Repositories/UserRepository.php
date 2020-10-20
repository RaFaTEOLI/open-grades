<?php

namespace App\Repositories;

use App\Http\Controllers\StudentController;
use App\InvitationLink;
use App\Repositories\UserRepositoryInterface;
use App\User;
use App\Student;
use App\Teacher;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

    public function register($request)
    {
        $invitationLinkRepository = new InvitationLinkRepository();
        try {
            $user = DB::transaction(function () use ($request, $invitationLinkRepository) {
                $request['password'] = Hash::make($request['password']);

                if (isset($request["hash"])) {
                    $invite = $invitationLinkRepository->getValidatedHash($request["hash"]);
                    $type = $invite->type;

                    unset($request["hash"]);
                } else {
                    // Separates the Type
                    $type = $request["type"];
                    unset($request["type"]);
                }

                // Saves the User
                $user = User::create($request);

                // Saves the User's Type
                $this->createType($type, $user->id);

                // Mark Link as Used
                if (!empty($invite)) {
                    $invite->update(['used_at' => Carbon::now()]);
                }

                return $user;
            });
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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
