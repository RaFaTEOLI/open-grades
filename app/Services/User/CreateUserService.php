<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\InvitationLinkRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\User;
use Exception;

class CreateUserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = (new UserRepository());
    }

    public function execute(array $request) {
        $invitationLinkRepository = new InvitationLinkRepository();

        try {
            $user = DB::transaction(function () use ($request, $invitationLinkRepository) {
                $request['password'] = Hash::make($request['password']);

                if (isset($request["hash"])) {
                    $invite = $invitationLinkRepository->getValidatedHash($request["hash"]);
                    $type = $invite->type;

                    unset($request["hash"]);
                } else {
                    // Separates the Type
                    $type = $request["type"];
                    unset($request["type"]);
                }

                // Saves the User
                $user = User::create($request);

                // Saves the User's Type
                $this->userRepository->createType($type, $user->id);

                // Mark Link as Used
                if (!empty($invite)) {
                    $invite->update(['used_at' => Carbon::now()]);
                }

                return $user;
            });
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
