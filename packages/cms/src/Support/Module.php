<?php
/**
 * @package    tadcms/tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 5/1/2021
 * Time: 4:31 PM
 */

namespace Juzaweb\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\Str;
use Juzaweb\Abstracts\Plugin as BasePlugin;

class Module extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    public function getCachedServicesPath(): string
    {
        return Str::replaceLast(
            'services.php',
            $this->getSnakeName() . '_module.php',
            $this->app->getCachedServicesPath()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerProviders(): void
    {
        try {
            (new ProviderRepository($this->app, new Filesystem(), $this->getCachedServicesPath()))
                ->load($this->getExtraLarevel('providers', []));
        } catch (\Throwable $e) {
            if (!config('app.debug')) {
                $this->disable();
            }

            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerAliases(): void
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->getExtraJuzaweb('aliases', []) as $aliasName => $aliasClass) {
            $loader->alias($aliasName, $aliasClass);
        }
    }
}
