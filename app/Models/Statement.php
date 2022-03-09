<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"statement"},
 * @OA\Xml(name="Statement"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="subject", type="string", example="Closed School"),
 * @OA\Property(property="statement", type="string", example="This is statement is to inform that the school will be closed this friday"),
 * )
 *
 * Class Statement
 *
 */
class Statement extends Model
{
    use HasFactory;
    protected $fillable = ["subject", "statement"];
    public $timestamps = true;

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "subject" => $this->subject,
            "statement" => $this->statement,
        ];
    }
}
