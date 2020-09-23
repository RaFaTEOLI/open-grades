<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\InvitationLinkRepository;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class InvitationLinkController extends Controller
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->invitationLinkRepository = (new InvitationLinkRepository());
    }

    public function index() {
        $invitations = $this->invitationLinkRepository->all();

        return response()->json($invitations, HttpStatus::SUCCESS);
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=> $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $input = $request->all();
            $invitation = $this->invitationLinkRepository->register($input);

            return response()->json($invitation, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    public function show($id) {
        $invitation = $this->invitationLinkRepository->findById($id);

        return response()->json($invitation, HttpStatus::SUCCESS);
    }

    public function update($id, $data) {
        $invitation = $this->invitationLinkRepository->update($id, $data);

        return response()->json($invitation, HttpStatus::SUCCESS);
    }

    public function destroy($id) {
        $this->invitationLinkRepository->delete($id);

        return response()->noContent();
    }
}
