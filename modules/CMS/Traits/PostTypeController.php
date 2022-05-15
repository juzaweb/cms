<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Backend\Events\AfterPostSave;
use Juzaweb\Backend\Http\Datatables\PostTypeDataTable;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

trait PostTypeController
{
    use ResourceController {
        ResourceController::afterSave as traitAfterSave;
        ResourceController::getDataForIndex as DataForIndex;
        ResourceController::getDataForForm as DataForForm;
    }

    /**
     * @return string
     */
    protected function getModel(...$params)
    {
        return Post::class;
    }

    /**
     * @param array $data
     * @param Post $model
     * @return void
     * @throws \Exception
     */
    protected function afterSave($data, $model, ...$params)
    {
        $this->traitAfterSave($data, $model, ...$params);
        $model->syncTaxonomies($data);

        if ($blocks = Arr::get($data, 'blocks', [])) {
            $data['meta']['block_content'] = collect($blocks)
                ->mapWithKeys(
                    function ($item, $key) {
                        return [$key => array_values($item)];
                    }
                )->toArray();
        }

        $meta = Arr::get($data, 'meta', []);

        $model->syncMetas($meta);

        do_action('post_types.after_save', $model, $data);
        do_action("post_type.{$this->getPostType()}.after_save", $model, $data);

        event(new AfterPostSave($model, $data));
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getTitle(...$params)
    {
        return $this->getSetting()->get('label');
    }

    protected function validator(array $attributes, ...$params)
    {
        $taxonomies = HookAction::getTaxonomies($this->getPostType());
        $keys = $taxonomies->keys()->toArray();

        $rules = [
            'title' => 'required|string|max:250',
            'description' => 'nullable|max:250',
            'status' => 'required|in:draft,publish,trash,private',
            'thumbnail' => 'nullable|string|max:150',
        ];

        foreach ($keys as $key) {
            $rules[$key] = 'nullable|array|max:10';
        }

        $validator = Validator::make($attributes, $rules);

        return $validator;
    }

    protected function getSetting()
    {
        $postType = $this->getPostType();
        $setting = HookAction::getPostTypes($postType);

        if (empty($setting)) {
            throw new \Exception('Post type does not exists.');
        }

        return $setting;
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\CMS\Abstracts\DataTable
     * @throws \Exception
     */
    protected function getDataTable(...$params)
    {
        $dataTable = new PostTypeDataTable();
        $dataTable->mountData($this->getSetting()->toArray());
        return $dataTable;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param $params
     * @return array
     *
     * @throws \Exception
     */
    protected function getDataForForm($model, ...$params)
    {
        do_action(Action::BLOCKS_INIT);

        $data = $this->DataForForm($model, ...$params);
        $setting = $this->getSetting();
        $templateData = $this->getTemplateData($model);

        $editor = 'cms::backend.post.components.editor';

        if (Arr::get($templateData, 'blocks', [])) {
            $editor = 'cms::backend.page-block.block';
        }

        $data['editor'] = $editor;

        return apply_filters(
            "post_type.{$this->getPostType()}.getDataForForm",
            array_merge(
                $data,
                [
                    'postType' => $setting->get('key'),
                    'model' => $model,
                    'setting' => $setting,
                    'templateData' => $templateData,
                ]
            )
        );
    }

    protected function getDataForIndex(...$params)
    {
        $data = $this->DataForIndex(...$params);
        $data['setting'] = $this->getSetting();
        return $data;
    }

    protected function parseDataForSave(array $attributes, ...$params)
    {
        $setting = $this->getSetting();
        $attributes['type'] = $setting->get('key');

        if (!empty($attributes['meta'])) {
            $metas = array_keys((array) $setting->get('metas'));
            $attributes['meta'] = collect($attributes['meta'])
                ->filter(
                    function ($val, $key) use ($metas) {
                        return in_array($key, $metas);
                    }
                )
                ->toArray();
        }

        $attributes = apply_filters(
            "post_type.{$this->getPostType()}.parseDataForSave",
            $attributes
        );

        return $attributes;
    }

    protected function checkPermission($ability, $arguments = [], ...$params)
    {
        $this->authorize($ability, [$arguments, $this->getPostType()]);
    }

    protected function getPermission($ability, $arguments = [], ...$params)
    {
        $response = Gate::inspect($ability, [$arguments, $this->getPostType()]);
        return $response->allowed();
    }

    /**
     * @param Post|\Illuminate\Database\Eloquent\Model $model
     * @return array|Collection
     */
    private function getTemplateData($model)
    {
        $template = $this->getTemplate($model);

        if (empty($template)) {
            return [];
        }

        $data = HookAction::getThemeTemplates($template);
        return $data;
    }

    /**
     * @param Post|\Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    private function getTemplate($model)
    {
        $template = request()->get('template');
        if (empty($template)) {
            $template = $model->getMeta('template');
        }

        return $template;
    }

    private function getPostType()
    {
        if (empty($this->postType)) {
            return request()->segment(3);
        }

        return $this->postType;
    }
}
