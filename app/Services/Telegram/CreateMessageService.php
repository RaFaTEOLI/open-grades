<?php

namespace App\Services\Telegram;

use App\Http\Controllers\Auth\AdminController;
use App\Repositories\Telegram\TelegramRepository;
use Exception;
use Illuminate\Support\Facades\Http;

class CreateMessageService
{
    private $telegramRepository;

    public function __construct()
    {
        $this->telegramRepository = (new TelegramRepository());
    }

    public function execute(array $request): void
    {
        try {
            AdminController::isAdminOrFail();

            Http::get("https://api.telegram.org/bot" . env('BOT_KEY') . "/sendMessage?chat_id=" . env('CHANNEL_ID') . "&text=" . $request["message"]);
            $this->telegramRepository->store($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
