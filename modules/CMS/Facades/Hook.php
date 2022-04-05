<?php

namespace Juzaweb\CMS\Facades;

/**
 * @method static void addFilter($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void addAction($tag, $callback, $priority = 20, $arguments = 1)
 * @method static mixed filter($tag, $value, ...$args)
 * @method static mixed action($tag, ...$args)
 */
class Hook extends Eventy
{
    // for backwards compatibility
}
