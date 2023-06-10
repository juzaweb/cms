<?php

namespace Juzaweb\Multilang\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\CMS\Models\Language;

class SettingController extends PageController
{
    public function index()
    {
        $title = trans('cms::app.setting');
        $languages = Language::get();
        $subdomains = get_config('mlla_subdomain', []);

        return view(
            'mlla::setting',
            compact(
                'title',
                'languages',
                'subdomains'
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $this->validate(
            $request,
            [
                'mlla_type' => [
                    'required',
                    'in:session,subdomain'
                ],
                'mlla_subdomain' => [
                    'required_if:mlla_type,==,subdomain',
                    'array'
                ],
            ]
        );

        $type = $request->post('mlla_type');
        $subdomain = [];
        $domains = [];

        if ($type == 'subdomain') {
            $languages = Language::get();
            $langCodes = $languages->pluck('code')->toArray();

            $subdomain = $request->post('mlla_subdomain', []);
            $subdomain = collect($subdomain)
                ->unique('language')
                ->unique('sub')
                ->map(function ($item) use ($request) {
                    $sub = Str::slug($item['sub']);
                    return [
                        'language' => $item['language'],
                        'sub' => $sub,
                        'domain' => $sub . '.' . $request->getHost(),
                    ];
                })
                ->filter(function ($item) use ($langCodes) {
                    return !empty($item['sub'])
                        && in_array($item['language'], $langCodes);
                })
                ->keyBy('domain');

            $domains = $subdomain->pluck('domain')->toArray();
            $subdomain = $subdomain->values();
        }

        DB::beginTransaction();
        try {
            set_config('mlla_type', $type);
            set_config('mlla_subdomain', $subdomain);

            DomainMapping::where('plugin', '=', 'multilang')
                ->whereNotIn('domain', $domains)
                ->delete();

            foreach ($subdomain as $sub) {
                DomainMapping::firstOrCreate(
                    [
                        'domain' => $sub['domain'],
                        'plugin' => 'multilang',
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully')
            ]
        );
    }
}
