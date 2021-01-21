<?php

namespace App\Services\Telegram;

use App\Http\Controllers\Auth\AdminController;
use App\Repositories\TelegramRepository;
use Exception;
use Illuminate\Support\Facades\Http;

class CreateMessageService
{
    private $telegramRepository;

    public function __construct()
    {
        $this->telegramRepository = (new TelegramRepository());
    }

    public function execute(array $request) {
        try {
            AdminController::isAdminOrFail();

            Http::get("https://api.telegram.org/bot".env('BOT_KEY')."/sendMessage?chat_id=".env('CHANNEL_ID')."&text=".$request["message"]);
            $this->telegramRepository->register($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
