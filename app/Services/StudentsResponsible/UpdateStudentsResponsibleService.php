<?php

namespace App\Services\StudentsResponsible;

use App\Models\StudentsResponsible;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class UpdateStudentsResponsibleService
{
    public function execute(array $request): bool
    {
        try {
            $invitationLinkRepository = new InvitationLinkRepository();
            $userId = Auth::user()->id;
            if (isset($request["hash"])) {
                $invite = $invitationLinkRepository->getValidatedHash($request["hash"]);
                $type = $invite->type;
                $studentId = $invite->student_id;

                if ($type) {
                    if ($type == "RESPONSIBLE") {
                        StudentsResponsible::create([
                            "student_id" => $studentId,
                            "responsible_id" => $userId,
                        ]);
                    }
                }
                // Mark Link as Used
                if (!empty($invite)) {
                    $invite->update(["used_at" => Carbon::now()]);
                }
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
