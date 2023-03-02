<?php

namespace App\Services\StudentClass;

use App\Exceptions\AlreadyEnrolled;
use App\Exceptions\NoStudentToEnroll;
use App\Exceptions\NotResponsible;
use App\Exceptions\StudentCannotEnroll;
use App\Models\StudentsClasses;
use App\Repositories\Configuration\ConfigurationRepository;
use Exception;
use App\Repositories\StudentClass\StudentClassRepository;
use App\Repositories\StudentsResponsible\StudentsResponsibleRepository;
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
                    throw new StudentCannotEnroll('Students are not allowed to enroll', 500);
                }
                $studentId = Auth::user()->id;
            } else {
                if (isset($request["student_id"])) {
                    $studentId = $request["student_id"];
                } else {
                    throw new NoStudentToEnroll('Cannot enroll, there is no student to enroll', 500);
                }
            }

            if (Auth::user()->hasRole('responsible')) {
                $isTheResponsible = (new StudentsResponsibleRepository())->findByResponsibleIdAndStudentId(Auth::user()->id, $studentId);
                if (!$isTheResponsible) {
                    throw new NotResponsible("Cannot enroll, you're not the student's responsible");
                }
            }

            $request["user_id"] = $studentId;
            $request["enroll_date"] = Carbon::now();

            $isThere = StudentsClasses::where('class_id', $request['class_id'])->where('user_id', $studentId)->get();

            if (count($isThere) > 0) {
                throw new AlreadyEnrolled("Cannot enroll, student is already enrolled", 500);
            }

            $studentClass = $studentClassRepository->store($request);

            return $studentClass;
        } catch (StudentCannotEnroll $e) {
            throw new StudentCannotEnroll($e->getMessage());
        } catch (NoStudentToEnroll $e) {
            throw new NoStudentToEnroll($e->getMessage());
        } catch (NotResponsible $e) {
            throw new NotResponsible($e->getMessage());
        } catch (AlreadyEnrolled $e) {
            throw new AlreadyEnrolled($e->getMessage());
        }
    }
}
