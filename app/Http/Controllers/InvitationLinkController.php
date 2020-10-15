<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\InvitationLinkRepository;
use Exception;

class InvitationLinkController extends Controller
{
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->invitationLinkRepository = (new InvitationLinkRepository());
    }

    public function index() {
        $invitations = $this->invitationLinkRepository->all();

        return view('admin/invitations', ["invitations" => $invitations]);
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            $input = $request->all();
            $invitation = $this->invitationLinkRepository->register($input);

            return view('admin/invitation', ["invitation" => $invitation]);
            //return redirect()->route('invitations')->withSuccess(__('actions.success'));
        } catch (Exception $e) {
            return back()->with('error', __('actions.error'));
        }
    }

    public function show($id) {
        $invitation = $this->invitationLinkRepository->findById($id);

        return view('admin/invitation', ["invitation" => $invitation]);
    }

    public function update($id, $data) {
        $invitation = $this->invitationLinkRepository->update($id, $data);

        return $invitation;
    }

    public function destroy($id) {
        try {
            $this->invitationLinkRepository->delete($id);

            return redirect()->route('invitations')->withSuccess(__('actions.success'));
        } catch (Exception $e) {
            return back()->with('error', __('actions.error'));
        }
    }
}