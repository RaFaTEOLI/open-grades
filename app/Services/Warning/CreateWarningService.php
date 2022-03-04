<?php

namespace App\Services\Warning;

use App\Repositories\Warning\WarningRepository;
use Illuminate\Support\Facades\Auth;
use Exception;

class CreateWarningService
{
    public function execute(array $request)
    {
        try {
            $warningRepository = new WarningRepository();
            $request['reporter_id'] = Auth::user()->id;

            return $warningRepository->store($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
