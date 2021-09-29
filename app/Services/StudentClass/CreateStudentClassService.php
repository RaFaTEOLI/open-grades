<?php

namespace App\Services\StudentClass;

use App\Repositories\Configuration\ConfigurationRepository;
use Exception;
use App\Repositories\StudentClass\StudentClassRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateStudentClassService
{
    public function execute(array $request)
    {
        try {
            $studentClassRepository = new StudentClassRepository();

            if (Auth::user()->hasRole('student')) {
                $canStudentEnroll = (new ConfigurationRepository())->findByName('can-student-enroll');
                if (!$canStudentEnroll->value) {
                    throw new Exception('Students are not allowed to enroll', 500);
                }
                $studentId = Auth::user()->id;
            } else {
                if (isset($request["student_id"])) {
                    $studentId = $request["student_id"];
                } else {
                    throw new Exception('Cannot enroll, there is no student to enroll', 500);
                }
            }

            $request["user_id"] = $studentId;
            $request["enroll_date"] = Carbon::today();
            $studentClass = $studentClassRepository->store($request);

            return $studentClass;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
