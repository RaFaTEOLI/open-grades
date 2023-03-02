<?php

namespace App\Repositories\Grade;

use App\Models\Grade;
use App\Repositories\Abstracts\AbstractRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GradeRepository extends AbstractRepository implements GradeRepositoryInterface
{
    protected $model = Grade::class;

    public function all(int $limit = 0, int $offset = 0): Collection | array
    {
        try {
            if (Auth::user()->hasRole('teacher')) {
                return Grade::when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                    ->when($offset && $limit, function ($query, $offset) {
                        return $query->offset($offset);
                    })
                    ->join('classes', 'classes.grade_id', 'grades.id')
                    ->where('classes.user_id', Auth::user()->id)
                    ->get(['grades.id', 'grades.name'])
                    ->map->format();
            }
            return Grade::when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
                ->when($offset && $limit, function ($query, $offset) {
                    return $query->offset($offset);
                })
                ->get()
                ->map->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function findById(int $id): object
    {
        try {
            return Grade::findOrFail($id)->first()->formatWithClasses();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
