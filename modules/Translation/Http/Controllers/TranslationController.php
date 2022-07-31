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

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\ArrayPagination;
use Juzaweb\Translation\Facades\Locale;

class TranslationController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view(
            'translation::translation.index',
            [
                'title' => trans('cms::app.translations'),
            ]
        );
    }

    public function getDataTable(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = $request->get('search');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $page = $offset <= 0 ? 1 : (round($offset / $limit)) + 1;

        $result = Locale::all();

        if ($search) {
            $result = collect($result)
                ->filter(
                    function ($item) use ($search) {
                        return (str_contains($item['title'], $search));
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
