<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Juzaweb\Backend\Http\Datatables\ResourceDatatable;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Traits\ResourceController as ResourceControllerTrait;

class ResourceController extends BackendController
{
    use ResourceControllerTrait {
        getDataForForm as DataForForm;
    }

    protected string $viewPrefix = 'cms::backend.resource';
    protected Collection $setting;
    protected Collection $postType;

    /*public function callAction($method, $parameters)
    {
        $params = array_values($parameters);

        if (!$this->getSetting(...$params)->get('menu')) {
            abort(404);
        }

        return parent::callAction($method, $parameters);
    }*/

    protected function afterSave($data, $model, ...$params)
    {
        if (method_exists($model, 'syncMetasWithoutDetaching')) {
            $model->syncMetasWithoutDetaching($data['meta'] ?? []);
        }
    }

    protected function getDataTable(...$params): DataTable
    {
        if ($dataTable = $this->getSetting(...$params)->get('datatable')) {
            $dataTable = app($dataTable);
            $dataTable->mountData(
                $params[0],
                $params[1] ?? null,
                $params[2] ?? null
            );

            return $dataTable;
        }

        $dataTable = new ResourceDatatable();
        $dataTable->mountData(
            $params[0],
            $params[1] ?? null,
            $params[2] ?? null
        );
        return $dataTable;
    }

    protected function validator(array $attributes, ...$params): array
    {
        $validator = $this->getSetting(...$params)->get('validator');
        if ($validator) {
            return $validator;
        }

        return [
            'name' => 'required',
            'display_order' => 'required|integer|min:1',
        ];
    }

    protected function getModel(...$params): string
    {
        if ($repository = $this->getSetting(...$params)->get('repository')) {
            return app($repository)->model();
        }

        return Resource::class;
    }

    protected function getTitle(...$params): string
    {
        return $this->getSetting($params[0])->get('label');
    }

    protected function getSetting(...$params): Collection
    {
        if (isset($this->setting)) {
            return $this->setting;
        }

        $this->setting = HookAction::getResource($params[0]);

        return $this->setting;
    }

    protected function parseDataForSave(array $attributes, ...$params)
    {
        $attributes['type'] = $params[0];
        if ($this->isUpdateRoute()) {
            if (isset($params[2])) {
                $attributes['post_id'] = (int) $params[1];
            }

            if (isset($params[3])) {
                $attributes['parent_id'] = (int) $params[2];
            }
        } else {
            $attributes['post_id'] = $params[1] ?? null;
            $attributes['parent_id'] = $params[2] ?? null;
        }

        return apply_filters(
            "resource.{$attributes['type']}.parseDataForSave",
            $attributes
        );
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model, ...$params);
        $data['setting'] = $this->getSetting(...$params);
        return $data;
    }

    protected function getPostType($type): Collection
    {
        if (isset($this->postType)) {
            return $this->postType;
        }

        $this->postType = HookAction::getPostTypes($type);

        return $this->postType;
    }
}
