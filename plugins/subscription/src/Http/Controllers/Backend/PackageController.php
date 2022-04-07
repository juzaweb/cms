<?php

namespace Juzaweb\Subscription\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Subscription\Facades\Subscription;
use Juzaweb\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Subscription\Http\Datatables\PackageDatatable;
use Juzaweb\Subscription\Models\Package;

class PackageController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
        parseDataForSave as DataForSave;
        afterSave as tAfterSave;
    }

    protected $viewPrefix = 'subr::backend.package';

    public function sync($id)
    {
        $package = Package::findOrFail($id);
        $data = get_config('subscription', []);

        foreach ($data as $key => $item) {
            $enable = (bool) Arr::get($item, 'enable', false);

            if (!$enable) {
                continue;
            }

            try {
                $planId = Subscription::driver($key)
                    ->setPackage($package)
                    ->syncPlan();
            } catch (\Exception $e) {
                Log::error($e);
                return $this->error([
                    'message' => $e->getMessage(),
                ]);
            }

            DB::beginTransaction();
            try {
                $package->plans()->updateOrCreate([
                    'method' => $key,
                ], [
                    'plan_id' => $planId
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return $this->success([
            'message' => trans('subr::content.sync_successfully')
        ]);
    }

    public function modalTest(Request $request)
    {
        $module = $request->input('module');
        $package = $request->input('package');

        return $this->success([
            'html' => view('subr::backend.package.components.test_modal', compact(
                'module',
                'package'
            ))->render()
        ]);
    }

    protected function getDataTable(...$params)
    {
        return new PackageDatatable();
    }

    protected function getDataForForm($model, ...$params)
    {
        $modules = HookAction::getPackageModules();

        $data = $this->DataForForm($model);
        $data['modules'] = $modules->map(function ($item) {
            return $item->get('name');
        })
            ->toArray();

        $data['configs'] = Arr::get($modules->first() ?: [], 'configs', []);
        $data['statuses'] = Package::getAllStatus();
        return $data;
    }

    protected function afterSave($data, $model, ...$params)
    {
        $this->tAfterSave($data, $model);

        $module = HookAction::getPackageModules($model->module);
        $configs = array_keys($module->get('configs'));

        $model->syncConfigs(collect($data['config'])->only($configs)->toArray());
    }

    protected function parseDataForSave(array $attributes, ...$params)
    {
        $data = $this->DataForSave($attributes);
        $feature = [];
        $features = Arr::get($data, 'data', []);
        $labels = Arr::get($features, 'label', []);
        $values = Arr::get($features, 'value', []);

        if (empty($data['is_free'])) {
            $data['is_free'] = 0;
        }

        if (Arr::exists($data, 'price')) {
            $data['price'] = str_replace(
                ',',
                '',
                $data['price']
            );
        }

        foreach ($labels as $key => $label) {
            $feature[] = [
                'label' => $label,
                'value' => $values[$key]
            ];
        }

        $data['data'] = $feature;

        return $data;
    }

    protected function validator(array $attributes, ...$params)
    {
        $modules = HookAction::getPackageModules()
            ->keys()
            ->toArray();

        $validator = Validator::make($attributes, [
            'name' => 'required|max:50',
            'price' => 'required_if:is_free,|regex:/^[0-9\.,]+$/',
            'status' => 'required|in:1,0',
            'module' => 'required|in:' . implode(',', $modules),
        ]);

        return $validator;
    }

    protected function getModel(...$params)
    {
        return Package::class;
    }

    protected function getTitle(...$params)
    {
        return trans('subr::content.packages');
    }
}
