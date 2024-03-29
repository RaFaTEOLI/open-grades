<?php

namespace App\Repositories\StudentClass;

use App\Exceptions\NotResponsible;
use App\Models\StudentsClasses;
use App\Repositories\Abstracts\AbstractRepository;
use App\Repositories\StudentsResponsible\StudentsResponsibleRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;

class StudentClassRepository extends AbstractRepository implements StudentClassRepositoryInterface
{
    protected $model = StudentsClasses::class;

    public function findClassesByStudentId(int $studentId): Collection
    {
        $students = StudentsClasses::where("user_id", $studentId)
            ->get()
            ->map
            ->format();
        if (Auth::user()->hasRole('responsible')) {
            $isResponsible = (new StudentsResponsibleRepository())->findByResponsibleIdAndStudentId(Auth::user()->id, $studentId);
            if (!empty($isResponsible)) {
                return $students;
            }
            throw new NotResponsible();
        } else {
            return $students;
        }
    }

    public function findClassesByStudentIdAndClassId(int $studentId, int $classId): object
    {
        try {
            return StudentsClasses::where("user_id", $studentId)->where("class_id", $classId)
                ->get()
                ->firstOrFail();
        } catch (ItemNotFoundException) {
            throw new ItemNotFoundException();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteByStudentAndClass(int $studentId, int $classId): bool
    {
        try {
            if (Auth::user()->hasRole('responsible')) {
                $isResponsible = (new StudentsResponsibleRepository())->findByResponsibleIdAndStudentId(Auth::user()->id, $studentId);
                if (!empty($isResponsible)) {
                    return StudentsClasses::where("user_id", $studentId)->where("class_id", $classId)
                        ->firstOrFail()->delete();
                }
                throw new NotResponsible();
            }
            return StudentsClasses::where("user_id", $studentId)->where("class_id", $classId)
                ->firstOrFail()->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
