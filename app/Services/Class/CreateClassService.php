<?php

namespace App\Services\Class;

use App\Exceptions\NoYearOngoing;
use App\Models\Year;
use Exception;
use App\Repositories\Classes\ClassRepository;

class CreateClassService
{
    public function execute(array $request)
    {
        try {
            $classRepository = new ClassRepository();

            $openYear = Year::where('closed', 0)->first();

            if (!$openYear) {
                throw new Exception(__('messages.no_year_ongoing'), 500);
            }

            $openYear = $openYear->format();

            $request["year_id"] = $openYear->id;
            $class = $classRepository->store($request);

            return $class;
        } catch (Exception $e) {
            throw new NoYearOngoing($e->getMessage());
        }
    }
}
