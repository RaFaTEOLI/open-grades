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

    /**
     * @OA\Get(
     * path="/messages",
     * summary="Get Messages",
     * description="Get a list of messages",
     * operationId="index",
     * tags={"Message"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Telegram")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index()
    {
        $results = $this->telegramRepository->all();

        return response()->json($results, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Post(
     * path="/messages",
     * summary="Create Message",
     * description="Create Message by passing a message",
     * operationId="store",
     * tags={"Message"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send message",
     *    @OA\JsonContent(
     *       required={"message"},
     *       @OA\Property(property="message", type="string", example="Hello, this is a message"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Telegram",
     *      ),
     *    ),
     *  ),
     * )
     */
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

    /**
     * @OA\Get(
     * path="/messages/{id}",
     * summary="Get Message",
     * @OA\Parameter(
     *      name="id",
     *      description="Message id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Message by id",
     * operationId="show",
     * tags={"Message"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Telegram",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            ValidationController::isIdValid($id);

            $result = $this->telegramRepository->findById($id);

            return response()->json($result, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
}
