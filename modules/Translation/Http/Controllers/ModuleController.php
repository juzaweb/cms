<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Translation\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\TranslationManager;
use Juzaweb\CMS\Support\ArrayPagination;
use Juzaweb\Translation\Facades\Locale;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Translation\Http\Requests\AddLanguageRequest;

class ModuleController extends BackendController
{
    public function __construct(protected TranslationManager $translationManager)
    {
    }

    public function index($type): View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.translations'),
                'url' => route('admin.translations.index')
            ]
        );

        $data = $this->translationManager->modules()->get($type);

        return view(
            'translation::translation.module',
            [
                'title' => $data->get('title'),
                'type' => $type
            ]
        );
    }

    public function add(AddLanguageRequest $request, $type): JsonResponse
    {
        $languages = $this->translationManager->locale($this->translationManager->modules()->get($type))->languages();
        $locale = $request->post('locale');

        if ($languages->get($locale)) {
            return $this->error(trans('cms::app.language_already_exist'));
        }

        $customs = get_config('custom_languages', []);
        $customs[$type][] = $locale;
        set_config('custom_languages', $customs);

        return $this->success(
            [
                'message' => trans('cms::app.add_language_successfull')
            ]
        );
    }

    public function getDataTable(Request $request, $type): JsonResponse
    {
        $search = $request->get('search');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $page = $offset <= 0 ? 1 : (round($offset / $limit)) + 1;
        $result = $this->translationManager->locale($this->translationManager->modules()->get($type))->languages();

        if ($search) {
            $result = collect($result)->filter(
                function ($item) use ($search) {
                    return (
                        str_contains($item['name'], $search) ||
                        str_contains($item['code'], $search)
                    );
                }
            );
        }

        $total = count($result);
        $items = ArrayPagination::make($result)->paginate($limit, $page)->values();

        return response()->json(
            [
                'total' => $total,
                'rows' => $items
            ]
        );
    }
}
