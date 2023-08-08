<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Module;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Requests\Module\ActivateByCodeRequest;
use Juzaweb\Backend\Http\Requests\Module\LoginJuzaWebRequest;
use Juzaweb\CMS\Contracts\JuzawebApiContract as JuzawebApi;
use Juzaweb\CMS\Http\Controllers\BackendController;

class BuyModuleController extends BackendController
{
    protected JuzawebApi $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function buyModal(Request $request, $module): JsonResponse|RedirectResponse
    {
        $name = $this->getNameModule($module, $request->input('module'));
        $moduleName = $this->getModuleName($module, $name);
        $title = "Activate {$moduleName}";
        $accessToken = $this->api->getAccessToken();
        $codes = $accessToken ? $this->getActivationCodes($module, $name) : [];

        return $this->success(
            [
                'html' => view(
                    'cms::components.modals.login_or_enter_key',
                    compact(
                        'module',
                        'moduleName',
                        'title',
                        'name',
                        'accessToken',
                        'codes'
                    )
                )
                    ->render()
            ]
        );
    }

    public function activateByCode(ActivateByCodeRequest $request, $module): JsonResponse|RedirectResponse
    {
        $name = $request->input('module');
        $code = $request->input('key');

        try {
            $response = $this->api->checkActivationCode($module, $name, $code);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        if (!empty($response->errors)) {
            return $this->error(
                $response->errors[0]?->message
            );
        }

        $activationCodes = get_config("{$module}_activation_codes", []);

        $activationCodes[Str::snake($name)] = [
            'code' => $code,
            'token' => $response->data->token,
            'certificate' => $response->data->certificate,
            'hash' => sha1($code),
        ];

        set_config("{$module}_activation_codes", $activationCodes);

        return $this->success('Activation successful.');
    }

    public function loginJuzaWeb(LoginJuzaWebRequest $request): JsonResponse|RedirectResponse
    {
        $email = $request->post('email');
        $password = $request->post('password');

        try {
            $login = $this->api->login($email, $password);
        } catch (\Exception $e) {
            report($e);
            return $this->error($e->getMessage());
        }

        if (empty($login)) {
            return $this->error(trans('cms::auth.failed'));
        }

        return $this->success('Login successful.');
    }

    protected function getActivationCodes(string $module, string $name): array
    {
        $codes = $this->api->getActivationCodes($module, $name);
        $codes = collect((array) $codes->data)->where('can_download', '=', true)
            ->mapWithKeys(
                function ($item) {
                    $title = "[{$item->id}] - {$item->title}";

                    return [
                        $item->code => $title,
                    ];
                }
            );

        return $codes->toArray();
    }

    protected function getNameModule(string $module, string $name): string
    {
        if ($module == 'theme') {
            return $name;
        }

        return explode('/', $name)[1];
    }

    protected function getModuleName(string $module, string $name): string
    {
        $module = $module == 'theme' ? trans('cms::app.theme') : trans('cms::app.plugin');
        return ucfirst($name) .' ' . $module;
    }
}
