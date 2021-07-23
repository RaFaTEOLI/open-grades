<?php

namespace App\Services\InvitationLink;

use App\Http\Controllers\Auth\AdminController;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Exception;

class RemoveInvitationLinkService
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->invitationLinkRepository = new InvitationLinkRepository();
    }

    public function execute(int $id): bool
    {
        try {
            AdminController::isAdminOrFail();

            $invitation = $this->invitationLinkRepository->findById($id);

            if ($invitation->used_at) {
                throw new Exception('You can\'t delete an invitation that has been used!', 400);
            }

            $this->invitationLinkRepository->delete($id);

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
