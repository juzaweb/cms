<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Http\Datatables\TaxonomyDataTable;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Traits\ResourceController;

class TaxonomyController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
        getDataForIndex as DataForIndex;
        store as TraitStore;
    }

    protected $viewPrefix = 'cms::backend.taxonomy';

    protected function getDataTable(...$params)
    {
        $postType = $params[0];
        $taxonomy = $params[1];
        $setting = $this->getSetting($postType, $taxonomy);
        $dataTable = new TaxonomyDataTable();
        $dataTable->mountData($setting->toArray());
        return $dataTable;
    }

    public function storeSuccessResponse($model, $request, ...$params)
    {
        $postType = $params[0];
        $taxonomy = $params[1];

        return $this->success([
            'message' => trans('cms::app.successfully'),
            'html' => view('cms::components.tag-item', [
                'item' => $model,
                'name' => $taxonomy,
            ])->render(),
        ]);
    }

    public function getTagComponent(Request $request, $postType, $taxonomy)
    {
        $item = Taxonomy::findOrFail($request->input('id'));

        return $this->response([
            'html' => view('cms::components.tag-item', [
                'item' => $item,
                'name' => $taxonomy,
            ])
                ->render(),
        ], true);
    }

    /**
     * Get post type by url
     *
     * @param string $postType
     * @return string
     */
    protected function getPostType($postType)
    {
        return Str::plural($postType);
    }

    /**
     * Get taxonomy setting
     *
     * @param string $taxonomy
     * @return \Illuminate\Support\Collection
     */
    protected function getSetting($postType, $taxonomy)
    {
        $taxonomies = GlobalData::get('taxonomies');

        return $taxonomies[$this->getPostType($postType)][$taxonomy] ?? collect([]);
    }

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    protected function validator(array $attributes, ...$params)
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * Get model resource
     *
     * @return string // namespace model
     */
    protected function getModel(...$params)
    {
        return Taxonomy::class;
    }

    /**
     * Get title resource
     *
     * @return string
     */
    protected function getTitle(...$params)
    {
        $postType = $params[0];
        $taxonomy = $params[1];

        $setting = $this->getSetting($postType, $taxonomy);

        return $setting->get('label');
    }

    protected function getDataForIndex(...$params)
    {
        $postType = $params[0];
        $taxonomy = $params[1];

        $data = $this->DataForIndex($postType, $taxonomy);
        $data['taxonomy'] = $taxonomy;
        $data['setting'] = $this->getSetting($postType, $taxonomy);
        return $data;
    }

    protected function getDataForForm($model, ...$params)
    {
        $postType = $params[0];
        $taxonomy = $params[1];

        $data = $this->DataForForm($model, $taxonomy);
        $data['taxonomy'] = $taxonomy;
        $data['setting'] = $this->getSetting($postType, $taxonomy);

        return $data;
    }

    protected function checkPermission($ability, $arguments = [], ...$params)
    {
        if (!is_array($arguments)) {
            $arguments = [$arguments];
        }

        $arguments[] = $params[0];
        $arguments[] = $params[1];
        $this->authorize($ability, $arguments);
    }

    protected function getPermission($ability, $arguments = [], ...$params)
    {
        if (!is_array($arguments)) {
            $arguments = [$arguments];
        }

        $arguments[] = $params[0];
        $arguments[] = $params[1];

        $response = Gate::inspect($ability, $arguments);
        return $response->allowed();
    }
}
