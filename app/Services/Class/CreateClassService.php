<?php

namespace App\Services\Class;

use App\Models\Year;
use Exception;
use App\Repositories\Class\ClassRepository;

class CreateClassService
{
    public function execute(array $request)
    {
        try {
            $classRepository = new ClassRepository();

            $openYear = Year::where('closed', 0)->firstOrFail()->format();

            if (!$openYear) {
                throw new Exception('Cannot create a class, there is no school year ongoing', 500);
            }

            $request["year_id"] = $openYear->id;
            $class = $classRepository->store($request);

            return $class;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
