<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;

class ActionRegister
{
    protected CacheManager $cache;
    protected array $actions = [];

    public function __construct(Application $app)
    {
        $this->cache = $app['cache'];
    }

    public function init(): void
    {
        foreach ($this->actions as $action) {
            app($action)->handle();
        }
    }

    /**
     * @param array|string $action
     */
    public function register(array|string $action): void
    {
        if (!is_array($action)) {
            $action = [$action];
        }

        foreach ($action as $item) {
            $this->actions[] = $item;
        }
    }
}
