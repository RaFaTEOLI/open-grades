<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Telegram\TelegramRequest;
use App\Repositories\Telegram\TelegramRepository;
use App\Services\Telegram\CreateMessageService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    private $telegramRepository;

    public function __construct()
    {
        $this->telegramRepository = new TelegramRepository();
    }

    public function index()
    {
        $results = $this->telegramRepository->all();

        return response()->json($results, HttpStatus::SUCCESS);
    }

    public function store(TelegramRequest $request)
    {
        try {
            $createMessageService = new CreateMessageService();

            $input = $request->all();

            $input["user_id"] = Auth::id();
            $result = $createMessageService->execute($input);

            return response()->json($result, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    public function show($id)
    {
        try {
            ValidationController::isIdValid($id);

            $result = $this->telegramRepository->findById($id);

            return response()->json($result, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $input = $request->all();

            $this->telegramRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
}
