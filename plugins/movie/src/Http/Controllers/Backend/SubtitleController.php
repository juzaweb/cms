<?php

namespace Juzaweb\Movie\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Juzaweb\Movie\Http\Datatables\SubtitleDatatable;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Movie\Models\Movie\Movie;
use Juzaweb\Movie\Models\Subtitle;
use Juzaweb\Movie\Models\Video\VideoFile;
use Juzaweb\CMS\Traits\ResourceController;

class SubtitleController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected $viewPrefix = 'mymo::movie_upload.subtitle';

    /**
     * Get data table resource
     *
     * @return \Juzaweb\CMS\Abstracts\DataTable
     */
    protected function getDataTable(...$params)
    {
        $page_type = $params[0];
        $file_id = $params[1];

        $dataTable = new SubtitleDatatable();
        $dataTable->mountData($page_type, $file_id);
        return $dataTable;
    }

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    protected function validator(array $attributes, $page_type, $file_id)
    {
        return [
            'label' => 'required|string|max:250',
            'url' => 'required|string|max:300',
            'order' => 'required|numeric|max:300',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Get model resource
     *
     * @param array $params
     * @return string // namespace model
     */
    protected function getModel($page_type, $file_id)
    {
        return Subtitle::class;
    }

    /**
     * Get title resource
     *
     * @param array $params
     * @return string
     */
    protected function getTitle($page_type, $file_id)
    {
        return trans('mymo::app.subtitle');
    }

    protected function getDataForForm($model, $page_type, $file_id)
    {
        $data = $this->DataForForm($model, $page_type, $file_id);
        $file = VideoFile::findOrFail($file_id);
        $data['page_type'] = $page_type;
        $data['file_id'] = $file_id;
        $data['file'] = $file;
        return $data;
    }
}
