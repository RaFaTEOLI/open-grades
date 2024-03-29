<?php

namespace App\Repositories\Classes;

use App\Models\Classes;
use App\Repositories\Abstracts\AbstractRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ClassRepository extends AbstractRepository implements ClassRepositoryInterface
{
    protected $model = Classes::class;

    /*
        Get All Class
    */
    public function all(int $limit = 0, int $offset = 0): Collection | array
    {
        try {
            if (Auth::user()->hasRole("student")) {
                $classes = Classes::when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                    ->when($offset && $limit, function ($query, $offset) {
                        return $query->offset($offset);
                    })->leftJoin('students_classes', 'classes.id', '=', 'students_classes.class_id')
                    ->whereNull('students_classes.class_id')
                    ->select('classes.*')
                    ->get()
                    ->map->format();
            } else if (Auth::user()->hasRole("teacher")) {
                $classes = $this->findByTeacherId(Auth::user()->id);
            } else {
                $classes = Classes::when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                    ->when($offset && $limit, function ($query, $offset) {
                        return $query->offset($offset);
                    })
                    ->get()
                    ->map->format();
            }

            return $classes;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function findByTeacherId(int $teacherId): Collection
    {
        try {
            return Classes::where('user_id', $teacherId)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function findByGradeId(int $gradeId): Collection
    {
        try {
            return Classes::where('grade_id', $gradeId)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
