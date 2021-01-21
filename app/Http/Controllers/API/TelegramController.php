<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Telegram\TelegramRepository;
use App\Services\Telegram\CreateMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    private $telegramRepository;

    public function __construct()
    {
        $this->telegramRepository = (new TelegramRepository());
    }

    public function index()
    {
        $results = $this->telegramRepository->all();

        return response()->json($results, HttpStatus::SUCCESS);
    }

    public function store(Request $request)
    {
        try {
            $createMessageService = new CreateMessageService();

            $validator = Validator::make($request->all(), [
                'message' => 'string|required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

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
