<?php

namespace App\Services\InvitationLink;

use App\Http\Controllers\Auth\AdminController;
use App\Models\InvitationLink;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class CreateInvitationLinkService
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->invitationLinkRepository = new InvitationLinkRepository();
    }

    public function execute(array $request): InvitationLink
    {
        try {
            AdminController::isAdminOrFail();

            $request["user_id"] = Auth::id();

            $request["hash"] = InvitationLink::generateHash();

            return $this->invitationLinkRepository->register($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
