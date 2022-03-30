<?php

namespace Juzaweb\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;

class ActionRegistion
{
    /**
     * @var CacheManager
     */
    protected $cache;
    protected $actions = [];

    public function __construct(Application $app)
    {
        $this->cache = $app['cache'];
    }

    public function init()
    {
        $actions = $this->actions;
        foreach ($actions as $action) {
            app($action)->handle();
        }
    }
    
    /**
     * @param string|array $action
     */
    public function register($action)
    {
        if (!is_array($action)) {
            $action = [$action];
        }
        
        foreach ($action as $item) {
            $this->actions[] = $item;
        }
    }
}
