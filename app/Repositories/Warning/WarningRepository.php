<?php

namespace App\Repositories\Warning;

use App\Models\Warning;
use App\Repositories\Abstracts\AbstractRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class WarningRepository extends AbstractRepository
{
    protected $model = Warning::class;

    public function all(int $limit = 0, int $offset = 0): Collection | array
    {
        $query = Warning::when($limit, function ($query, $limit) {
            return $query->limit($limit);
        })->when($offset && $limit, function ($query, $offset) {
            return $query->offset($offset);
        });

        if (Auth::user()->hasRole('teacher')) {
            return $query
                ->join('classes', 'warnings.class_id', 'classes.id')
                ->where('classes.user_id', Auth::user()->id)
                ->get(['warnings.id', 'warnings.student_id', 'warnings.class_id', 'warnings.reporter_id', 'warnings.description', 'warnings.created_at', 'warnings.updated_at'])
                ->map->format();
        }
        if (Auth::user()->hasRole('student')) {
            return $query
                ->where('student_id', Auth::user()->id)
                ->get(['warnings.id', 'warnings.student_id', 'warnings.class_id', 'warnings.reporter_id', 'warnings.description', 'warnings.created_at', 'warnings.updated_at'])
                ->map->format();
        }
        if (Auth::user()->hasRole('responsible')) {
            return $query
                ->join('classes', 'warnings.class_id', 'classes.id')
                ->join('students_responsible', 'students_responsible.student_id', 'warnings.student_id')
                ->join('users', 'users.id', 'students_responsible.responsible_id')
                ->where('students_responsible.responsible_id', Auth::user()->id)
                ->get(['warnings.id', 'warnings.student_id', 'warnings.class_id', 'warnings.reporter_id', 'warnings.description', 'warnings.created_at', 'warnings.updated_at'])
                ->map->format();
        }
        return $query->get()->map->format();
    }
}
