<?php

namespace Juzaweb\Crawler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Crawler\Helpers\Converter\BBCodeToHtml;
use Juzaweb\Crawler\Models\CrawTemplate;
use Juzaweb\Crawler\Models\Component;
use Juzaweb\Crawler\Models\CrawRemoveElement;
use Juzaweb\Crawler\Helpers\Leech\LeechComponent;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ComponentController extends BackendController
{
    public function index($templateId)
    {
        $model = CrawTemplate::findOrFail($templateId);
        $linkAction = action([static::class, 'save'], [$templateId]);
        $linkPreview = action([static::class, 'preview'], [$templateId]);

        $this->addBreadcrumb(
            [
                'title' => trans('crawler::content.templates'),
                'url' => action([TemplateController::class, 'index'])
            ]
        );

        return view('crawler::component.index', [
            'title' => trans('crawler::content.component'),
            'model' => $model,
            'linkAction' => $linkAction,
            'linkPreview' => $linkPreview,
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validate(
            $request,
            [
                'crawler_title' => 'required',
                'crawler_content' => 'required',
                'components.*.code' => 'required',
                'components.*.element' => 'required',
                'removes.*.element' => 'required',
                'removes.*.type' => 'required|in:1,2',
            ]
        );

        DB::beginTransaction();
        try {
            $model = CrawTemplate::findOrFail($request->post('id'));
            $model->fill($request->all());
            $model->save();

            $components = $request->post('components', []);
            $componentIds = [];

            foreach ($components as $item) {
                $row = $model->components()->updateOrCreate(
                    [
                        'id' => $item['component_id']
                    ],
                    $item
                );

                $componentIds[] = $row->id;
            }

            $model->components()
                ->whereNotIn('id', $componentIds)
                ->delete();

            $removes = $request->post('removes');
            $removeIds = [];

            foreach ($removes as $item) {
                $row = $model->removes()->updateOrCreate(
                    [
                        'id' => $item['remove_id']
                    ],
                    $item
                );

                $removeIds[] = $row->id;
            }

            $model->removes()
                ->whereNotIn('id', $removeIds)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
                'redirect' => action([static::class, 'index'], [$model->id]),
            ]
        );
    }
    
    public function preview($templateId, Request $request)
    {
        $this->validate(
            $request,
            [
                'preview_url' => 'required',
            ]
        );
    
        CrawTemplate::findOrFail($templateId);
        $url = $request->post('preview_url');
        $coms = $request->post('components', []);
        $res = $request->post('removes', []);

        $components = [];
        foreach ($coms as $item) {
            $component = new Component();
            $component->fill($item);
            $components[] = $component;
        }

        $removes = [];
        foreach ($res as $item) {
            $remove = new CrawRemoveElement();
            $remove->fill($item);
            $removes[] = $remove;
        }

        $crawlerComponent = new LeechComponent($url, $components, $removes);
        $componentsLeech = $crawlerComponent->leech();

        $content = map_crawler_params(
            $request->post('crawler_content'),
            $componentsLeech
        );

        $toHtml = new BBCodeToHtml($content);
        $content = $toHtml->toHtml();
        $thumbnail = map_crawler_params(
            $request->post('crawler_thumbnail'),
            $componentsLeech
        );

        if ($thumbnail && !is_url($thumbnail)) {
            $thumbnail = get_full_url(
                $thumbnail,
                base_domain($url)
            );
        }
        
        return $this->success(
            [
                'title' => map_crawler_params(
                    $request->post('crawler_title'),
                    $componentsLeech
                ),
                'thumbnail' => $thumbnail,
                'content' => $content,
            ]
        );
    }
}
