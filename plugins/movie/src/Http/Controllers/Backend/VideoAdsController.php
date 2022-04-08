<?php

namespace Juzaweb\Movie\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Movie\Http\Datatables\VideoAdsDatatable;
use Juzaweb\Movie\Models\Video\VideoAds;
use Juzaweb\CMS\Traits\ResourceController;

class VideoAdsController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'mymo::setting.video_ads';

    /**
     * Get data table resource
     *
     * @return \Juzaweb\CMS\Abstracts\DataTable
     */
    protected function getDataTable(...$params)
    {
        return new VideoAdsDatatable();
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
            'name' => 'required|string|max:250',
            'title' => 'required|string|max:250',
            'url' => 'required|string|max:250',
            'video_url' => 'required|string|max:250',
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Get model resource
     *
     * @param array $params
     * @return string // namespace model
     */
    protected function getModel(...$params)
    {
        return VideoAds::class;
    }

    /**
     * Get title resource
     *
     * @param array $params
     * @return string
     */
    protected function getTitle(...$params)
    {
        return trans('mymo::app.video_ads');
    }
}
