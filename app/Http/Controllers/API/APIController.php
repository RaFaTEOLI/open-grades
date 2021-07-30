<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApiResponseTime;
use App\Repositories\Example\ExampleRepository;
use Illuminate\Support\Carbon;

class APIController extends Controller
{
    /**
     * @OA\Get(
     * path="/metrics",
     * summary="Get API Metrics",
     * description="Get metrics from API",
     * operationId="metrics",
     * tags={"API"},
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/ApiResponseTime",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function metrics()
    {
        return response()->json(
            [
                "average_response_time" => ApiResponseTime::whereDay('created_at', Carbon::today())
                    ->where('count', '<>', 0)
                    ->avg('time') / 1000,
                "requests_count" => ApiResponseTime::whereDay('created_at', Carbon::today())->sum('count'),
            ]
        );
    }

    /**
     * @OA\Get(
     * path="/version",
     * summary="Get API Version",
     * description="Get API Version",
     * operationId="version",
     * tags={"API"},
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="version", type="string", readOnly="true", example="1.0.0"),
     *      ),
     *    ),
     *  ),
     * )
     */
    public function version()
    {
        return response()->json(["version" => env("APP_VERSION")], 200);
    }

    /**
     * @OA\Get(
     * path="/health",
     * summary="Get Status 200 if API is running",
     * description="Get Status 200 if API is running",
     * operationId="health",
     * tags={"API"},
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", readOnly="true", example="It's working"),
     *      ),
     *    ),
     *  ),
     * )
     */
    public function health()
    {
        return response()->json(["message" => "It's working"], 200);
    }
}
