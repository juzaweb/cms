<?php

namespace Juzaweb\Multilang\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\Multilang\Http\Datatables\LanguageDatatable;
use Juzaweb\CMS\Models\Language;

class LanguageController extends PageController
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $title = trans('cms::app.languages');
        $dataTable = new LanguageDatatable();

        return view('mlla::language', compact(
            'title',
            'dataTable'
        ));
    }

    public function addLanguage(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $locales = config('locales');
        $supported = array_keys($locales);

        $this->validate($request, [
            'code' => 'required|string|max:10|in:' . implode(',', $supported),
        ]);

        $code = $request->post('code');
        $name = $locales[$code]['name'];

        if (Language::existsCode($code)) {
            return $this->error([
                'message' => trans('cms::app.language_already_exist'),
            ]);
        }

        Language::create([
            'code' => $code,
            'name' => $name
        ]);

        return $this->success(
            [
                'message' => trans('cms::app.add_language_successfull'),
            ]
        );
    }

    public function toggleDefault($code): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        Language::setDefault($code);

        return $this->success(
            [
                'message' => trans('cms::app.change_language_successfull'),
            ]
        );
    }
}
