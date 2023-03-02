<?php

namespace App\Services\Statement;

use App\Notifications\Statement;
use App\Repositories\Statement\StatementRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Notification;

class CreateStatementService
{
    public function execute(array $request)
    {
        try {
            $statement = (new StatementRepository())->store($request);
            $users = (new UserRepository())->allButAdmin();

            Notification::send($users, new Statement($statement));

            return $statement;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
