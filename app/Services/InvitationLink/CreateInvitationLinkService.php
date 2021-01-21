<?php

namespace App\Services\InvitationLink;

use App\Http\Controllers\Auth\AdminController;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class CreateInvitationLinkService
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->invitationLinkRepository = (new InvitationLinkRepository());
    }

    public function execute(array $request) {
        try {
            AdminController::isAdminOrFail();

            $request["user_id"] = Auth::id();

            $request["hash"] = $this->invitationLinkRepository->generateHash();

            return $this->invitationLinkRepository->register($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
