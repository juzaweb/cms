<?php

namespace Juzaweb\Translation\Http\Controllers;

use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\Translation\Http\Datatables\TranslationDatatable;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends PageController
{
    public function index()
    {
        $lang = get_config('language', 'en');
        $title = trans('cms::app.translations');
        $dataTable = new TranslationDatatable();
        $dataTable->mountData($lang);

        return view('jutr::translation', compact(
            'title',
            'dataTable',
            'lang'
        ));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'key' => 'required',
            'namespace' => 'required',
            'text' => 'required',
        ]);

        $lang = get_config('language', 'en');

        $line = LanguageLine::where($request->only([
            'group',
            'key',
            'namespace',
        ]))->firstOrNew();

        $text = $line->text ? $line->text : [];
        $text[$lang] = $request->post('text');

        $line->fill($request->only([
            'group',
            'key',
            'namespace',
        ]));
        $line->text = $text;

        $line->save();

        return $this->success([
            'message' => trans('cms::app.save_successfully')
        ]);
    }
}
