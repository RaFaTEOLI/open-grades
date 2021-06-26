<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsResponsible\StudentResponsibleLinkRequest;
use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Repositories\Student\StudentRepository;
use App\Services\StudentsResponsible\RemoveStudentsResponsibleService;
use Exception;

class StudentsResponsibleController extends Controller
{
    private $studentRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->studentRepository = new StudentRepository();
    }

    public function link(StudentResponsibleLinkRequest $request)
    {
        try {
            $input = $request->only(["student_id"]);
            $input["type"] = "RESPONSIBLE";

            $createInvitationLinkService = new CreateInvitationLinkService();
            $link = $createInvitationLinkService->execute($input);

            $student = $this->studentRepository->findById($input["student_id"]);

            return view("students/student", ["student" => $student, "invitation" => $link]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $studentId, int $responsibleId)
    {
        try {
            (new RemoveStudentsResponsibleService())->execute([
                "student_id" => $studentId,
                "responsible_id" => $responsibleId,
            ]);

            return back()->with("success", __("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
