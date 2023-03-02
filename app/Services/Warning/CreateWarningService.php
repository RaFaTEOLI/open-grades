<?php

namespace App\Services\Warning;

use App\Models\User;
use App\Notifications\StudentWarning;
use App\Repositories\Student\StudentRepository;
use App\Repositories\StudentsResponsible\StudentsResponsibleRepository;
use App\Repositories\Warning\WarningRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;
use Exception;

class CreateWarningService
{
    private static function objectToCollection($object)
    {
        $user = new User();
        foreach ($object as $k => $v)
            $user->{$k} = $v;
        return $user;
    }
    public function execute(array $request)
    {
        try {
            $student = (new StudentRepository())->findById($request['student_id']);

            $warningRepository = new WarningRepository();
            $request['reporter_id'] = Auth::user()->id;

            $warning = $warningRepository->store($request)->format();
            $responsibles = (new StudentsResponsibleRepository())->findByStudentId($request['student_id']);
            if (!empty($responsibles)) {
                foreach ($responsibles as $responsible) {
                    $this->objectToCollection($responsible)->notify(new StudentWarning($student, $warning));
                }
            }

            return $warning;
        } catch (ItemNotFoundException $i) {
            throw new ItemNotFoundException($i->getMessage(), $i->getCode());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
