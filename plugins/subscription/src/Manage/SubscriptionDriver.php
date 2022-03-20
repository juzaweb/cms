<?php

namespace Juzaweb\Subscription\Manage;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Juzaweb\Subscription\Models\Package;

abstract class SubscriptionDriver
{
    protected $driver;
    /**
     * @var Package $package
     */
    protected $package;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function setPackage(Package $package)
    {
        $this->package = $package;
        return $this;
    }

    abstract public function syncPlan();

    abstract public function redirect();

    abstract public function return($data);

    /**
     * @param Request $request
     * @return \Juzaweb\Subscription\Models\SubscriptionHistory
     */
    abstract public function notify(Request $request);

    protected function getPlan()
    {
        return $this->package->plans()
            ->where('method', '=', $this->driver)
            ->first();
    }

    protected function getConfig()
    {
        $data = get_config('subscription');
        return Arr::get($data, $this->driver, []);
    }
}
