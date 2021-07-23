<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Exception;
use App\Models\StudentsResponsible;
use App\Models\User;

class CreateUserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function execute(array $request): User
    {
        $invitationLinkRepository = new InvitationLinkRepository();

        try {
            $user = DB::transaction(function () use ($request, $invitationLinkRepository) {
                $type = null;
                $request["password"] = Hash::make($request["password"]);

                if (isset($request["hash"])) {
                    $invite = $invitationLinkRepository->getValidatedHash($request["hash"]);
                    $type = $invite->type;
                    $studentId = $invite->student_id;

                    unset($request["hash"]);
                } elseif (isset($request["type"])) {
                    // Separates the Type
                    $type = $request["type"];
                    unset($request["type"]);
                }

                // Saves the User
                $user = $this->userRepository->store($request);

                if ($type) {
                    if ($type == "RESPONSIBLE") {
                        StudentsResponsible::create([
                            "student_id" => $studentId,
                            "responsible_id" => $user->id,
                        ]);
                    }
                    // Saves the User's Type
                    $this->userRepository->createType($type, $user->id);
                }

                // Mark Link as Used
                if (!empty($invite)) {
                    $invite->update(["used_at" => Carbon::now()]);
                }

                return $user;
            });
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
