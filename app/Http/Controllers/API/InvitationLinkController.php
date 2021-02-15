<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationLink\InvitationLinkRequest;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Exception;
use App\Services\InvitationLink\CreateInvitationLinkService;

class InvitationLinkController extends Controller
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->invitationLinkRepository = new InvitationLinkRepository();
    }

    public function index()
    {
        $invitations = $this->invitationLinkRepository->all();

        return response()->json($invitations, HttpStatus::SUCCESS);
    }

    public function store(InvitationLinkRequest $request)
    {
        try {
            $createInvitationLinkService = new CreateInvitationLinkService();

            $input = $request->all();
            $invitation = $createInvitationLinkService->execute($input);

            return response()->json($invitation, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    public function show($id)
    {
        $invitation = $this->invitationLinkRepository->findById($id);

        return response()->json($invitation, HttpStatus::SUCCESS);
    }

    public function update($id, $data)
    {
        $invitation = $this->invitationLinkRepository->update($id, $data);

        return response()->json($invitation, HttpStatus::SUCCESS);
    }

    public function destroy($id)
    {
        $this->invitationLinkRepository->delete($id);

        return response()->noContent();
    }
}
