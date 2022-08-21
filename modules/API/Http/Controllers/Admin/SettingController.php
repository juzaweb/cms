<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\ApiController;
use OpenApi\Annotations as OA;

class SettingController extends ApiController
{
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
    public function configs()
    {
        dd(HookAction::getConfigs()->keys());
    }
}
