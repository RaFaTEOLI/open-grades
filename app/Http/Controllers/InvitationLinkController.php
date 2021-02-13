<?php

namespace App\Http\Controllers;

use App\Models\InvitationLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use App\Services\InvitationLink\CreateInvitationLinkService;
use Exception;

class InvitationLinkController extends Controller
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->invitationLinkRepository = new InvitationLinkRepository();
    }

    public function index()
    {
        $invitations = $this->invitationLinkRepository->all();

        return view("admin/invitation/invitations", ["invitations" => $invitations]);
    }

    public function store(Request $request)
    {
        try {
            $createInvitationLinkService = new CreateInvitationLinkService();

            $validator = Validator::make(
                $request->all(),
                InvitationLink::validationRules(),
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $input = $request->all();

            $invitation = $createInvitationLinkService->execute($input);

            return view("admin/invitation/invitations", ["invitation" => $invitation]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show($id)
    {
        $invitation = $this->invitationLinkRepository->findById($id);

        return view("admin/invitation/invitations", ["invitation" => $invitation]);
    }

    public function update($id, $data)
    {
        $invitation = $this->invitationLinkRepository->update($id, $data);

        return $invitation;
    }

    public function destroy($id)
    {
        try {
            $this->invitationLinkRepository->delete($id);

            return redirect()
                ->route("invitations")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
