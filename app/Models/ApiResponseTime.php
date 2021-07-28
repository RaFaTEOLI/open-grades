<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="ApiResponseTime"),
 * @OA\Property(property="average_response_time", type="integer", readOnly="true", example="0.1395"),
 * @OA\Property(property="requests_count", type="string", description="Name of the user", example="25"),
 * )
 *
 * Class ApiResponseTime
 *
 */
class ApiResponseTime extends Model
{
    protected $table = 'api_response_time';
    protected $fillable = [
        'time',
        'count'
    ];
}
