<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApiResponseTime;
use Illuminate\Support\Carbon;

class MetricsController extends Controller
{
    /**
     * @OA\Get(
     * path="/metrics",
     * summary="Get API Metrics",
     * description="Get metrics from API",
     * operationId="index",
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
    public function index()
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
}
