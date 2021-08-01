<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationLink\InvitationLinkRequest;
use App\Http\Traits\Pagination;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Exception;
use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\InvitationLink\RemoveInvitationLinkService;
use Illuminate\Http\Request;

class InvitationLinkController extends Controller
{
    use Pagination;
    private $invitationLinkRepository;

    public function __construct()
    {
        $this->invitationLinkRepository = new InvitationLinkRepository();
    }

    /**
     * @OA\Get(
     * path="/invitations",
     * summary="Get Invitations",
     * description="Get a list of invitations",
     * operationId="index",
     * tags={"Invitation"},
     * security={ {"bearerAuth":{}} },
     * @OA\Parameter(
     *      name="offset",
     *      description="Offset for pagination",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="limit",
     *      description="Limit of results for pagination",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/InvitationLink")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        $paginated = $this->paginate($request);
        $invitations = $this->invitationLinkRepository->all($paginated["limit"], $paginated["offset"]);

        return response()->json($invitations, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Post(
     * path="/invitations",
     * summary="Create Invitations",
     * description="Create Invitations by type",
     * operationId="store",
     * tags={"Invitation"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send type to create invitation [TEACHER, STUDENT]",
     *    @OA\JsonContent(
     *       required={"type"},
     *       @OA\Property(property="type", type="string", example="STUDENT"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/InvitationLink",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(InvitationLinkRequest $request)
    {
        try {
            $createInvitationLinkService = new CreateInvitationLinkService();

            $input = $request->all();
            $invitation = $createInvitationLinkService->execute($input)->format();

            return response()->json($invitation, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * @OA\Get(
     * path="/invitations/{id}",
     * summary="Get Invitation",
     * @OA\Parameter(
     *      name="id",
     *      description="Invitation id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Invitation by id",
     * operationId="show",
     * tags={"Invitation"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/InvitationLink",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $invitation = $this->invitationLinkRepository->findById($id);

            return response()->json($invitation, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $invitation = $this->invitationLinkRepository->update($id, $data);

            return response()->json($invitation, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Delete(
     * path="/invitations/{id}",
     * summary="Delete Invitation",
     * @OA\Parameter(
     *      name="id",
     *      description="Invitation id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete invitation by id",
     * operationId="destroy",
     * tags={"Invitation"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $removeInvitationLinkService = new RemoveInvitationLinkService();

            $removeInvitationLinkService->execute($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode() == '400' ? HttpStatus::BAD_REQUEST : HttpStatus::SERVER_ERROR);
        }
    }
}
