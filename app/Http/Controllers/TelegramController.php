<?php

namespace App\Http\Controllers;

use App\Models\Telegram;
use App\Repositories\Telegram\TelegramRepository;
use App\Services\Telegram\CreateMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TelegramController extends Controller
{
    private $telegramRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->telegramRepository = new TelegramRepository();
    }

    public function index()
    {
        $results = $this->telegramRepository->all();

        return view("messages/messages", ["messages" => $results]);
    }

    public function store(Request $request)
    {
        try {
            $createMessageService = new CreateMessageService();

            $validator = Validator::make(
                $request->all(),
                Telegram::validationRules(),
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $input = $request->all();
            $createMessageService->execute($input);

            return redirect()
                ->route("message")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show($id)
    {
        $result = $this->telegramRepository->findById($id);

        return view("message/message", ["message" => $result]);
    }

    public function update($id, Request $request)
    {
        $input = $request->all();

        $this->telegramRepository->update($id, $input);

        return redirect()
            ->route("message")
            ->withSuccess(__("actions.success"));
    }
}
