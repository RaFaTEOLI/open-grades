<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Dashboard"),
 * @OA\Property(property="totalStudents", type="integer", readOnly="true", example="8"),
 * @OA\Property(property="newStudents", type="integer", readOnly="true", example="3"),
 * @OA\Property(property="totalTeachers", type="integer", readOnly="true", example="5"),
 * )
 *
 * Class Dashboard
 *
 */
class Dashboard extends Model
{
}
