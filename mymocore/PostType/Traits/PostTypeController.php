<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/9/2021
 * Time: 2:05 PM
 */

namespace Mymo\PostType\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mymo\Core\Traits\ResourceController;
use Mymo\PostType\PostType;
use Illuminate\Support\Facades\Validator;

trait PostTypeController
{
    use ResourceController {
        ResourceController::afterSave as traitAfterSave;
    }

    public function index()
    {
        return view($this->viewPrefix . '.index', [
            'title' => $this->getSetting()->get('label')
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->getSetting()->get('label'),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel();
        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('mymo_core::app.add_new')
        ], $this->getDataDataForForm($model)));
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->getSetting()->get('label'),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel()->findOrFail($id);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->name ?? $model->title
        ], $this->getDataDataForForm($model)));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     * */
    abstract protected function getModel();

    abstract public function getDataTable(Request $request);

    protected function afterSave(Request $request, $model)
    {
        $this->traitAfterSave($request, $model);
        $model->syncTaxonomies($request->all());
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

        foreach ($ids as $id) {
            switch ($action) {
                case 'delete':
                    $this->makeModel()->find($id)->delete($id);
                    break;
                case 'publish':
                case 'private':
                case 'draft':
                    $this->makeModel()->find($id)->update([
                        'status' => $action
                    ]);
                    break;
            }
        }

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }

    protected function getTitle()
    {
        return $this->getSetting()->get('label');
    }

    protected function validator(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'title' => 'required|string|max:250',
            'description' => 'nullable',
            'status' => 'required|in:draft,publish,trash,private',
            'thumbnail' => 'nullable|string|max:150',
        ]);

        return $validator;
    }

    protected function getSetting()
    {
        $setting = PostType::getPostTypes($this->makeModel()->getPostType());
        if (empty($setting)) {
            throw new \Exception('Post type ' . $this->makeModel()->getPostType() . ' does not exists.');
        }

        return $setting;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     * */
    protected function getDataDataForForm($model)
    {
        return [
            'postType' => $model->getPostType(),
            'model' => $model
        ];
    }
}