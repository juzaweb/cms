<?php

namespace Juzaweb\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Http\Controllers\Controller;
use Juzaweb\Subscription\Events\PaymentSuccess;
use Juzaweb\Subscription\Facades\Subscription;
use Juzaweb\Subscription\Models\Package;
use Juzaweb\Models\User;
use Juzaweb\Subscription\Models\SubscriptionHistory;

class SubscriptionController extends Controller
{
    public function handleRedirect(Request $request, $driver, $packageKey)
    {
        $package = Package::findByKey($packageKey);
        $objectId = $request->input('object_id');

        if (empty($package) || $package->status != 1) {
            return abort(404, "Package {$packageKey} not found");
        }

        session()->put("subscription_object_{$package->module}", $objectId);

        try {
            $url = Subscription::driver($driver)
                ->setPackage($package)
                ->redirect();
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }

            Log::error($e);
            return redirect()
                ->to($package->getReturnUrl())
                ->withErrors($e->getMessage());
        }

        return redirect()->to($url);
    }

    public function handleReturn(Request $request, $driver, $packageKey)
    {
        $package = Package::findByKey($packageKey);

        $result = Subscription::driver($driver)
            ->setPackage($package)
            ->return($request->all());

        if ($result['error']) {
            return redirect()->to($package->getReturnUrl())
                ->withErrors([$result['message']]);
        }

        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $objectId = session()->get("subscription_object_{$package->module}");

            $subscriber = new SubscriptionHistory();
            $subscriber->method = $driver;
            $subscriber->user_id = $userId;
            $subscriber->object_id = $objectId;
            $subscriber->package_id = $package->id;
            $subscriber->module = $package->module;
            $subscriber->fill($result['data']);
            $subscriber->amount = 0;
            $subscriber->save();

            session()->forget("subscription_object_{$package->module}");

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->to($package->getReturnUrl())
            ->with([
                'status' => 'success',
                'message' => $result['message']
            ]);
    }

    public function handleCancel($driver, $packageKey)
    {
        $package = Package::findByKey($packageKey);
        return redirect()->to($package->getReturnUrl());
    }

    public function handleNotify(Request $request, $driver)
    {
        $data = $request->all();
        Log::info("Notify {$driver}: " . json_encode($data));

        try {
            $agreement = Subscription::driver($driver)->notify($request);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }

            Log::error($e);
            return response('Error: Invalid webhook. Agreement failed', 500);
        }

        if (empty($agreement)) {
            Log::info("Empty agreement");

            return response('Error: Invalid webhook. Empty agreement', 500);
        }

        $module = HookAction::getPackageModules($agreement->module);
        $object = $module->get('model')::find($agreement->object_id);

        if (empty($object)) {
            Log::error('Empty object. ' . json_encode($data));
            return response('Error: Invalid webhook. Empty object.', 500);
        }

        DB::beginTransaction();
        try {
            $amount = $agreement->package->price;

            $history = $agreement->replicate();
            $history->token = Str::random(32);
            $history->amount = $amount;
            $history->save();

            $nextDate = date("Y-m-d", strtotime("+1 month"));

            $subscriber = $object->subscription()->updateOrCreate([
                'module' => $agreement->module
            ], [
                'method' => $driver,
                'amount' => $amount,
                'next_payment' => $nextDate,
                'package_id' => $agreement->package_id,
                'agreement_id' => $agreement->agreement_id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (config('app.debug')) {
                throw $e;
            }
            Log::error($e);
            return response('Error: Invalid webhook. Save data', 500);
        }

        DB::beginTransaction();
        try {
            $config = $agreement->package->getModuleConfig();
            if ($config) {
                $successClass = $config->get('success');

                if ($successClass) {
                    (new $successClass(
                        $subscriber,
                        $agreement,
                        $data
                    ))->handle();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
        }

        event(new PaymentSuccess(
            $subscriber,
            $agreement,
            $data
        ));

        return response('Webhook Handled', 200);
    }
}
