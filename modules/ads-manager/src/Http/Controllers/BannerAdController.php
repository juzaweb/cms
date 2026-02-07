<?php

namespace Juzaweb\Modules\AdsManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\AdsManagement\Facades\Ads;
use Juzaweb\Modules\AdsManagement\Http\DataTables\BannerAdsDataTable;
use Juzaweb\Modules\AdsManagement\Http\Requests\BannerAdRequest;
use Juzaweb\Modules\AdsManagement\Models\BannerAds;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\Core\Http\Requests\BulkActionsRequest;

class BannerAdController extends AdminController
{
    public function index(BannerAdsDataTable $dataTable)
    {
        Breadcrumb::add(__('ad-management::translation.banner_ads'));

        return $dataTable->render(
            'ad-management::banner-ads.index'
        );
    }

    public function create()
    {
        Breadcrumb::add(__('ad-management::translation.banner_ads'), action([static::class, 'index']));

        Breadcrumb::add(__('ad-management::translation.create_banner_ads'));

        $locale = $this->getFormLanguage();
        $action = action([static::class, 'store']);
        $model = new BannerAds();
        $positions = Ads::bannerPositions();

        return view(
            'ad-management::banner-ads.form',
            compact('action', 'locale', 'model', 'positions')
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('ad-management::translation.banner_ads'), action([static::class, 'index']));

        $model = BannerAds::findOrFail($id);

        Breadcrumb::add(__('ad-management::translation.edit_banner_ads_name', ['name' => $model->name]));

        $locale = $this->getFormLanguage();
        $action = action([static::class, 'update'], [$id]);
        $positions = Ads::bannerPositions();
        $position = $model->positions()->first()->position ?? null;

        return view(
            'ad-management::banner-ads.form',
            compact('action', 'locale', 'model', 'positions', 'position')
        );
    }

    public function store(BannerAdRequest $request)
    {
        $model = DB::transaction(
            function () use ($request) {
                $data = $request->validated();
                if ($data['type'] === 'html') {
                    $data['body'] = $data['body_html'];
                } else {
                    $data['body'] = $data['body_image'];
                }
                unset($data['body_html'], $data['body_image']);

                $banner = BannerAds::create($data);

                $banner->positions()->create([
                    'position' => $data['position'],
                ]);

                return $banner;
            }
        );

        return $this->success(
            [
                'message' => __('ad-management::translation.created_ads_banner_name_successfully', ['name' => $model->name]),
                'redirect' => action([static::class, 'index']),
            ]
        );
    }

    public function update(BannerAdRequest $request, string $id)
    {
        $model = BannerAds::findOrFail($id);

        DB::transaction(
            function () use ($request, $model) {
                $data = $request->validated();
                if ($data['type'] === 'html') {
                    $data['body'] = $data['body_html'];
                } else {
                    $data['body'] = $data['body_image'];
                }
                unset($data['body_html'], $data['body_image']);

                $model->update($data);

                $model->positions()->delete();
                $model->positions()->create([
                    'position' => $data['position'],
                ]);
            }
        );

        return $this->success(
            [
                'message' => __('ad-management::translation.updated_ads_banner_name_successfully', ['name' => $model->name]),
                'redirect' => action([static::class, 'index']),
            ]
        );
    }

    public function bulk(BulkActionsRequest $request): JsonResponse|RedirectResponse
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        switch ($action) {
            case 'delete':
                BannerAds::whereIn('id', $ids)
                    ->get()
                    ->each
                    ->delete();
                return $this->success(__('ad-management::translation.deleted_selected_ads_banners_successfully'));
            case 'activate':
                BannerAds::whereIn('id', $ids)
                    ->get()
                    ->each
                    ->update(['active' => true]);
                return $this->success(__('ad-management::translation.activated_selected_ads_banners_successfully'));
            case 'deactivate':
                BannerAds::whereIn('id', $ids)
                    ->get()
                    ->each
                    ->update(['active' => false]);
                return $this->success(__('ad-management::translation.deactivated_selected_ads_banners_successfully'));
            default:
                return $this->error(__('core::translation.invalid_action'));
        }
    }
}
