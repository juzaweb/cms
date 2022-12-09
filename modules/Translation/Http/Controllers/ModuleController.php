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
use Juzaweb\CMS\Support\ArrayPagination;
use Juzaweb\Translation\Facades\Locale;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ModuleController extends BackendController
{
    public function index($type): View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.translations'),
                'url' => route('admin.translations.index')
            ]
        );

        $data = Locale::getByKey($type);

        return view(
            'translation::translation.module',
            [
                'title' => $data->get('title'),
                'type' => $type
            ]
        );
    }

    public function add(Request $request, $type): JsonResponse
    {
        $locale = $request->post('locale');
        $publishPath = Locale::publishPath($type, $locale);

        if (is_dir($publishPath)) {
            return $this->error(
                [
                    'message' => trans('cms::app.language_already_exist')
                ]
            );
        }

        try {
            File::makeDirectory($publishPath, 0755, true);
            File::put("{$publishPath}/.gitkeep", '');
        } catch (\Throwable $e) {
            return $this->error(
                [
                    'message' => $e->getMessage()
                ]
            );
        }

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

        $result = Locale::allLanguage($type);

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
