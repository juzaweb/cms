<?php

namespace Juzaweb\Modules\AdsManagement\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\AdsManagement\Facades\Ads;
use Juzaweb\Modules\AdsManagement\Http\DataTables\VideoAdsDatatable;
use Juzaweb\Modules\AdsManagement\Http\Requests\VideoAdsActionsRequest;
use Juzaweb\Modules\AdsManagement\Http\Requests\VideoAdsRequest;
use Juzaweb\Modules\AdsManagement\Models\VideoAds;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;

class VideoAdsController extends AdminController
{
    public function index(VideoAdsDatatable $dataTable)
    {
        Breadcrumb::add(__('ad-management::translation.video_ads'));

        $createUrl = action([static::class, 'create']);

        return $dataTable->render(
            'ad-management::video-ad.index',
            compact('createUrl')
        );
    }

    public function create()
    {
        Breadcrumb::add(__('ad-management::translation.video_ads'), admin_url('videoads'));

        Breadcrumb::add(__('ad-management::translation.create_video_ad'));

        $backUrl = action([static::class, 'index']);
        $positions = Ads::videoPositions();

        return view(
            'ad-management::video-ad.form',
            [
                'model' => new VideoAds(),
                'action' => action([static::class, 'store']),
                'backUrl' => $backUrl,
                'positions' => $positions,
            ]
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('ad-management::translation.video_ads'), admin_url('videoads'));

        Breadcrumb::add(__('ad-management::translation.create_video_ads'));

        $model = VideoAds::findOrFail($id);
        $backUrl = action([static::class, 'index']);
        $positions = Ads::videoPositions();

        return view(
            'ad-management::video-ad.form',
            [
                'action' => action([static::class, 'update'], [$id]),
                'model' => $model,
                'backUrl' => $backUrl,
                'positions' => $positions,
            ]
        );
    }

    public function store(VideoAdsRequest $request)
    {
        $model = DB::transaction(
            function () use ($request) {
                $data = $request->validated();

                return VideoAds::create($data);
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('ad-management::translation.videoads_name_created_successfully', ['name' => $model->name]),
        ]);
    }

    public function update(VideoAdsRequest $request, string $id)
    {
        $model = VideoAds::findOrFail($id);

        $model = DB::transaction(
            function () use ($request, $model) {
                $data = $request->validated();

                $model->update($data);

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('ad-management::translation.videoads_name_updated_successfully', ['name' => $model->name]),
        ]);
    }

    public function bulk(VideoAdsActionsRequest $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        $models = VideoAds::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            if ($action === 'activate') {
                $model->update(['active' => true]);
            }

            if ($action === 'deactivate') {
                $model->update(['active' => false]);
            }

            if ($action === 'delete') {
                $model->delete();
            }
        }

        return $this->success([
            'message' => __('ad-management::translation.bulk_action_performed_successfully'),
        ]);
    }
}
