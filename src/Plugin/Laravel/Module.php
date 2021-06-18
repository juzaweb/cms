<?php
/**
 * @package    tadcms/tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/1/2021
 * Time: 4:31 PM
 */

namespace Mymo\Plugin\Laravel;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\Str;
use Mymo\Plugin\Plugin as BaseModule;

class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public function getCachedServicesPath(): string
    {
        return Str::replaceLast('services.php', $this->getSnakeName() . '_module.php', $this->app->getCachedServicesPath());
    }

    /**
     * {@inheritdoc}
     */
    public function registerProviders(): void
    {
        (new ProviderRepository($this->app, new Filesystem(), $this->getCachedServicesPath()))
            ->load($this->getExtraLarevel('providers'));
    }

    /**
     * {@inheritdoc}
     */
    public function registerAliases(): void
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->getExtraLarevel('aliases') as $aliasName => $aliasClass) {
            $loader->alias($aliasName, $aliasClass);
        }
    }
}
