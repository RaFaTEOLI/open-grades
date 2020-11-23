<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\TelegramRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
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
            $validator = Validator::make($request->all(), [
                'message' => 'string|required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $input = $request->all();

            Http::get("https://api.telegram.org/bot".env('BOT_KEY')."/sendMessage?chat_id=".env('CHANNEL_ID')."&text=".$input["message"]);

            $input["user_id"] = Auth::id();
            $result = $this->telegramRepository->register($input);

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
