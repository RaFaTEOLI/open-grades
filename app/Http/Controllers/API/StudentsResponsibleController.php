<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentsResponsible\StudentResponsibleLinkRequest;
use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\StudentsResponsible\RemoveStudentsResponsibleService;
use Exception;

class StudentsResponsibleController extends Controller
{
    public function link(StudentResponsibleLinkRequest $request)
    {
        try {
            $input = $request->only(["student_id"]);
            $input["type"] = "RESPONSIBLE";

            $createInvitationLinkService = new CreateInvitationLinkService();
            $link = $createInvitationLinkService->execute($input);

            return response()->json(["invitation" => $link], HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function destroy($studentId, $responsibleId)
    {
        try {
            (new RemoveStudentsResponsibleService())->execute([
                "student_id" => $studentId,
                "responsible_id" => $responsibleId,
            ]);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
}
