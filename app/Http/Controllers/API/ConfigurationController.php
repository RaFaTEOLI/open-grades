<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuration\ConfigurationRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Services\Configuration\CreateConfigurationService;
use Illuminate\Http\Request;
use Exception;

class ConfigurationController extends Controller
{
    use Pagination;
    private $configurationRepository;

    public function __construct()
    {
        $this->configurationRepository = new ConfigurationRepository();
    }

    /**
     * @OA\Get(
     * path="/configurations",
     * summary="Get Configurations",
     * description="Get a list of configurations",
     * operationId="index",
     * tags={"Configuration"},
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
     *         @OA\Items(ref="#/components/schemas/Configuration")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);

            $configurations = $this->configurationRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($configurations, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], ($e->getCode() == '500') ? HttpStatus::SERVER_ERROR : HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * @OA\Post(
     * path="/configurations",
     * summary="Create Configuration",
     * description="Create Configuration by name, value",
     * operationId="store",
     * tags={"Configuration"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, value",
     *    @OA\JsonContent(
     *       required={"name","value"},
     *       @OA\Property(property="name", type="string", example="school-year-division"),
     *       @OA\Property(property="value", type="string", example="4"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Configuration",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(ConfigurationRequest $request)
    {
        try {
            $createConfigurationService = new CreateConfigurationService();

            $input = $request->all();
            $configuration = $createConfigurationService->execute($input);

            return response()->json($configuration, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * @OA\Get(
     * path="/configurations/{id}",
     * summary="Get Configuration",
     * @OA\Parameter(
     *      name="id",
     *      description="Configuration id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Configuration by id",
     * operationId="show",
     * tags={"Configuration"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Configuration",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            ValidationController::isIdValid($id);

            $configuration = $this->configurationRepository->findById($id);

            return response()->json($configuration, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/configurations/{id}",
     * summary="Update Configuration",
     * description="Update Configuration",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Configuration"},
     * @OA\Parameter(
     *      name="id",
     *      description="Configuration id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, value to update configuration",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="school-year-division"),
     *       @OA\Property(property="value", type="string", example="4"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function update(int $id, Request $request)
    {
        try {
            $input = $request->all();

            $this->configurationRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Delete(
     * path="/configurations/{id}",
     * summary="Delete Configuration",
     * @OA\Parameter(
     *      name="id",
     *      description="Configuration id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete configuration by id",
     * operationId="destroy",
     * tags={"Configuration"},
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
            $this->configurationRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
}
