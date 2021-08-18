<?php

namespace App\Services\Year;

use App\Models\Year;
use Exception;
use App\Repositories\Year\YearRepository;

class OpenSchoolYearService
{
    public function execute(array $request)
    {
        try {
            $yearRepository = new YearRepository();

            $isOpen = Year::where('closed', 0)->get();

            if (count($isOpen)) {
                foreach ($isOpen as $year) {
                    $year->update(["closed" => 1]);
                }
            }

            $year = $yearRepository->store($request);

            return $year;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
