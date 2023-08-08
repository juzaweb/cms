<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Juzaweb\CMS\Contracts\ConfigContract;
use Juzaweb\CMS\Http\Controllers\ApiController;
use OpenApi\Annotations as OA;

class SettingController extends ApiController
{
    public function __construct(protected ConfigContract $config)
    {
    }

    /**
     * @OA\Get(
     *      path="/api/admin/setting/configs",
     *      tags={"Admin / Setting"},
     *      summary="Get admin configs",
     *      operationId="admin.setting.configs",
     *      @OA\Response(response=200, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function configs(): JsonResponse
    {
        $storageUrl = rtrim(Storage::disk('public')->url('/'), '/');

        return $this->restSuccess(
            [
                'storage_url' => $storageUrl,
                'general' => $this->config->all(),
            ]
        );
    }
}
