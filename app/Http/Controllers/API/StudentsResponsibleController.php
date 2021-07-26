<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentsResponsible\StudentResponsibleLinkRequest;
use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\StudentsResponsible\RemoveStudentsResponsibleService;
use Exception;

class StudentsResponsibleController extends Controller
{
    /**
     * @OA\Post(
     * path="/student-responsible",
     * summary="Create Invitation Student's Responsible",
     * description="Create invitation link for a student's responsible",
     * operationId="link",
     * tags={"Student"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send student_id for a link",
     *    @OA\JsonContent(
     *       required={"student_id"},
     *       @OA\Property(property="student_id", type="integer", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      @OA\Property(property="invitation", type="object", ref="#/components/schemas/StudentsResponsible"),
     *      ),
     *    ),
     *  ),
     * )
     */
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

    /**
     * @OA\Delete(
     * path="/students/{studentId}/responsible/{responsibleId}",
     * summary="Delete Student's Responsible",
     * @OA\Parameter(
     *      name="studentId",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="responsibleId",
     *      description="Responsible id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete student's Responsible by id",
     * operationId="destroy",
     * tags={"Student"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function destroy(int $studentId, int $responsibleId)
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
