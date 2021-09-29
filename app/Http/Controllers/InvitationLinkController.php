<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationLink\InvitationLinkRequest;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\StudentsResponsible\UpdateStudentsResponsibleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view("admin/invitation/invitations", ["invitations" => $invitations]);
    }

    public function store(InvitationLinkRequest $request)
    {
        try {
            $createInvitationLinkService = new CreateInvitationLinkService();

            $input = $request->all();

            $invitation = $createInvitationLinkService->execute($input);

            return view("admin/invitation/invitations", ["invitation" => $invitation]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        $invitation = $this->invitationLinkRepository->findById($id);

        return view("admin/invitation/invitations", ["invitation" => $invitation]);
    }

    public function update(int $id, array $data)
    {
        try {
            $invitation = $this->invitationLinkRepository->update($id, $data);

            return $invitation;
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
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

    public function handle(Request $request)
    {
        try {
            if ($request->has('hash')) {
                $hash = $request->query('hash');

                if (Auth::user()) {
                    (new UpdateStudentsResponsibleService())->execute(["hash" => $hash]);
                    return redirect()
                        ->route("students")
                        ->withSuccess(__("actions.success"));
                } else {
                    return redirect(env('APP_URL') . "/register?hash={$hash}");
                }
            }
        } catch (Exception $e) {
            if ($e->getMessage() == __("validation.invalid_link")) {
                return redirect()
                    ->route("students")->with("error", $e->getMessage());
            }
            return back()->with("error", __("actions.error"));
        }
    }
}
