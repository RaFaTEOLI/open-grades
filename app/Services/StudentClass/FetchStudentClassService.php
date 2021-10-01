<?php

namespace App\Services\StudentClass;

use App\Exceptions\NotResponsible;
use Exception;
use App\Repositories\StudentClass\StudentClassRepository;
use App\Repositories\StudentsResponsible\StudentsResponsibleRepository;
use Illuminate\Support\Facades\Auth;

class FetchStudentClassService
{
    public function execute(int $id)
    {
        try {
            $studentClassRepository = new StudentClassRepository();

            if (Auth::user()->hasRole('responsible')) {
                $studentId = $studentClassRepository->findById($id)->user_id;

                $isTheResponsible = (new StudentsResponsibleRepository())->findByResponsibleIdAndStudentId(Auth::user()->id, $studentId);
                if (!$isTheResponsible) {
                    throw new NotResponsible("Cannot fetch, you're not the student's responsible");
                }
            } else if (Auth::user()->hasRole('student')) {
                $studentId = $studentClassRepository->findById($id)->user_id;

                if (Auth::user()->id != $studentId) {
                    throw new NotResponsible("Cannot fetch, this is not your class");
                }
            }

            return $studentClassRepository->findById($id)->format();
        } catch (NotResponsible $e) {
            throw new NotResponsible($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
