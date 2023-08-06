<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
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

    protected string $viewPrefix = 'cms::backend.taxonomy';

    //protected string $template = 'inertia';

    protected function getDataTable(...$params): TaxonomyDataTable
    {
        [$postType, $taxonomy] = $params;
        $setting = $this->getSetting($postType, $taxonomy);
        $dataTable = new TaxonomyDataTable();
        $dataTable->mountData($setting->toArray());
        return $dataTable;
    }

    public function storeSuccessResponse($model, $request, ...$params): JsonResponse|RedirectResponse
    {
        $taxonomy = $params[1];

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
                'item' => $model,
                'html' => view(
                    'cms::components.tag-item',
                    [
                        'item' => $model,
                        'name' => $taxonomy,
                    ]
                )->render(),
            ]
        );
    }

    public function getTagComponent(Request $request, $postType, $taxonomy): JsonResponse|RedirectResponse
    {
        $item = Taxonomy::findOrFail($request->input('id'));

        return $this->response(
            [
                'html' => view(
                    'cms::components.tag-item',
                    [
                        'item' => $item,
                        'name' => $taxonomy,
                    ]
                )->render(),
            ],
            true
        );
    }

    /**
     * Get post type by url
     *
     * @param string $postType
     * @return string
     */
    protected function getPostType(string $postType): string
    {
        return Str::plural($postType);
    }

    /**
     * Get taxonomy setting
     *
     * @param $postType
     * @param string $taxonomy
     * @return Collection
     */
    protected function getSetting(...$params): Collection
    {
        $taxonomies = GlobalData::get('taxonomies');

        return $taxonomies[$this->getPostType($params[0])][$params[1]] ?? collect([]);
    }

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @param mixed ...$params
     * @return array
     */
    protected function validator(array $attributes, ...$params): array
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
    protected function getModel(...$params): string
    {
        return Taxonomy::class;
    }

    /**
     * Get title resource
     *
     * @param mixed ...$params
     * @return string
     */
    protected function getTitle(...$params): string
    {
        $postType = $params[0];
        $taxonomy = $params[1];

        $setting = $this->getSetting($postType, $taxonomy);

        return $setting->get('label');
    }

    protected function getDataForIndex(...$params): array
    {
        $postType = $params[0];
        $taxonomy = $params[1];

        $data = $this->DataForIndex($postType, $taxonomy);
        $data['taxonomy'] = $taxonomy;
        $data['setting'] = $this->getSetting($postType, $taxonomy);
        return $data;
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model, ...$params);
        $data['taxonomy'] = $params[1];
        $data['setting'] = $this->getSetting(...$params);
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

    protected function hasPermission($ability, $arguments = [], ...$params): bool
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
