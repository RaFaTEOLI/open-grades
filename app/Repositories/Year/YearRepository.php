<?php

namespace App\Repositories\Year;

use App\Models\Year;
use App\Repositories\Abstracts\AbstractRepository;
use Exception;
use Illuminate\Support\Collection;

class YearRepository extends AbstractRepository
{
    protected $model = Year::class;

    public function all(int $limit = 0, int $offset = 0): Collection | array
    {
        return Year::when($limit, function ($query, $limit) {
            return $query->limit($limit);
        })
            ->when($offset && $limit, function ($query, $offset) {
                return $query->offset($offset);
            })
            ->orderBy('closed')
            ->get()
            ->map->format();
    }
}
