<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;

use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 * @OA\Schema(
 * required={"name", "email"},
 * @OA\Xml(name="User"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Name of the user", example="John Doe"),
 * @OA\Property(property="email", type="string", format="email", description="User unique email address", example="johndoe@email.com"),
 * @OA\Property(property="photo", type="string", format="string", description="User photo", example="/images/johndoe.png"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when user was created", example="2019-02-25 12:59:20"),
 * )
 *
 * Class User
 *
 */
class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;
    use LaravelEntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["name", "email", "password", "deleted_at"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "roles" => $this->roles()
                ->get()
                ->map->formatWithoutPermissions(),
        ];
    }

    public function formatSimple()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
            "created_at" => $this->created_at,
        ];
    }
}
