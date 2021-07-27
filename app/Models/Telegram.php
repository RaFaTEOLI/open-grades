<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"message"},
 * @OA\Xml(name="Telegram"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="message", type="string", description="Message that you want to send", example="Hello! I was sent by an API"),
 * @OA\Property(property="user", type="object", ref="#/components/schemas/UserRoles"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when message was created", example="2019-02-25 12:59:20"),
 *
 * )
 *
 * Class Telegram
 *
 */
class Telegram extends Model
{
    protected $table = "telegram";
    protected $fillable = ["message", "user_id"];

    /**
     * Get the user record associated with the message
     */
    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "message" => $this->message,
            "user" => $this->user->format(),
            "created_at" => $this->created_at,
        ];
    }
}
