<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\MessageBag;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="Open Api",
 *      @OA\Contact(
 *          email="admin@juzaweb.com"
 *      )
 * ),
 * @OA\Parameter(
 *      parameter="id_in_path",
 *      name="id",
 *      in="path",
 *      required=true,
 *      @OA\Schema(type="string")
 *  ),
 * @OA\Parameter(
 *      parameter="slug_in_path",
 *      name="slug",
 *      in="path",
 *      required=true,
 *      @OA\Schema(type="string")
 *  ),
 *  @OA\Parameter(
 *      parameter="path_code",
 *      name="code",
 *      in="path",
 *      required=true,
 *      @OA\Schema(type="string")
 *  ),
 *  @OA\Parameter(
 *      parameter="query_limit",
 *      name="limit",
 *      in="query",
 *      @OA\Schema(type="integer")
 *  ),
 *  @OA\Parameter(
 *      parameter="query_page",
 *      name="page",
 *      in="query",
 *      @OA\Schema(type="integer")
 *  ),
 *  @OA\Parameter(
 *      parameter="query_keyword",
 *      name="keyword",
 *      in="query",
 *      @OA\Schema(type="string")
 *  ),
 *  @OA\Response(
 *      response="success_detail",
 *      description="Get Data Success",
 *      @OA\JsonContent(
 *          @OA\Property(property="data", type="object"),
 *      )
 *  ),
 *  @OA\Response(
 *      response="success_list",
 *      description="Get List Success",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="data",
 *              type="array",
 *              @OA\Items(type="object")
 *          ),
 *      )
 *  ),
 *  @OA\Response(
 *      response="success_paging",
 *      description="Get Paging Success",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="data",
 *              type="array",
 *              @OA\Items(type="object")
 *          ),
 *          @OA\Property(
 *              property="links",
 *              type="object",
 *              @OA\Property(property="self", type="string"),
 *              @OA\Property(property="first", type="string"),
 *              @OA\Property(property="prev", type="string"),
 *              @OA\Property(property="next", type="string"),
 *              @OA\Property(property="last", type="string")
 *          ),
 *          @OA\Property(
 *              property="meta",
 *              type="object",
 *              @OA\Property(property="totalPages", type="integer"),
 *              @OA\Property(property="limit", type="integer"),
 *              @OA\Property(property="total", type="integer"),
 *              @OA\Property(property="page", type="integer")
 *          ),
 *      )
 *  ),
 *  @OA\Response(
 *      response="error_401",
 *      description="Token Error",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="errors",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="code", type="string", example=""),
 *                  @OA\Property(property="title", type="string", example="")
 *              )
 *          ),
 *          @OA\Property(property="message", type="string", example=""),
 *      )
 *  ),
 *  @OA\Response(
 *      response="error_403",
 *      description="Permission denied",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="errors",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="code", type="string", example=""),
 *                  @OA\Property(property="title", type="string", example="")
 *              )
 *          ),
 *          @OA\Property(property="message", type="string", example=""),
 *      )
 *  ),
 *  @OA\Response(
 *      response="error_404",
 *      description="Page not found",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="errors",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="code", type="string", example=""),
 *                  @OA\Property(property="title", type="string", example="")
 *              )
 *          ),
 *          @OA\Property(property="message", type="string", example=""),
 *      )
 *  ),
 *  @OA\Response(
 *      response="error_422",
 *      description="Validate Error",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="errors",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="field", type="string", example=""),
 *                  @OA\Property(property="message", type="string", example="")
 *              )
 *          ),
 *          @OA\Property(property="message", type="string", example=""),
 *      )
 *  ),
 *  @OA\Response(
 *      response="error_500",
 *      description="Server Error",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="errors",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="code", type="string", example=""),
 *                  @OA\Property(property="title", type="string", example="")
 *              )
 *          ),
 *          @OA\Property(property="message", type="string", example=""),
 *      )
 *  )
 */
class ApiController extends Controller
{
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()
            ->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->restFail($validator->errors())->send();
            exit(1);
        }
    }

    protected function getQueryLimit($request = null): int
    {
        $request = $request ?: request();
        $limit = $request->get('limit', 10);
        if ($limit > 100) {
            return 10;
        }

        return $limit;
    }

    protected function restSuccess($data, string $message = '', int $status = 200): JsonResponse
    {
        $response = [
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, $status);
    }

    protected function restFail($errors, string $message = '', int $status = 422): JsonResponse
    {
        switch (true) {
            case $errors instanceof MessageBag:
                $errorsResult = [];
                foreach ($errors->getMessages() as $field => $items) {
                    foreach ($items as $error) {
                        $errorsResult[] = [
                            'field' => $field,
                            'message' => $error,
                        ];
                    }
                }

                break;
            default:
                $errorsResult = $errors;

                break;
        }
        $response = [
            'errors' => $errorsResult,
            'message' => $message,
        ];

        return response()->json($response, $status);
    }

    protected function restPaginate($paginate, string $message = '', int $status = 200): JsonResponse
    {
        $currentPage = $paginate->currentPage();
        $lastPage = $paginate->lastPage();
        $response = [
            'data' => $paginate->items(),
            'links' => [
                'self' => $paginate->url($currentPage),
                'first' => $paginate->url(1),
                'prev' => $paginate->previousPageUrl(),
                'next' => $paginate->nextPageUrl(),
                'last' => $paginate->url($lastPage),
            ],
            'meta' => [
                'totalPages' => $lastPage,
                'limit' => $paginate->perPage(),
                'total' => $paginate->total(),
                'page' => $currentPage,
            ],
            'message' => $message,
        ];

        return response()->json($response, $status);
    }

    protected function checkPermission(Request $request, $ability, $arguments = [])
    {
        $this->authorizeForUser(
            $request->user('api'),
            $ability,
            $arguments
        );
    }

    protected function hasPermission($ability, $arguments = []): bool
    {
        $response = Gate::inspect($ability, $arguments);
        return $response->allowed();
    }
}
