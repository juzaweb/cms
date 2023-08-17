<?php

namespace Juzaweb\CMS\Support;

use Composer\Autoload\ClassLoader;
use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Translation\Translator;
use Illuminate\View\ViewFinderInterface;
use Juzaweb\CMS\Contracts\ActivatorInterface;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Juzaweb\CMS\Interfaces\Theme\PluginInterface;
use Noodlehaus\Config as ReadConfig;

class Plugin implements PluginInterface
{
    use Macroable;

    protected ApplicationContract $app;

    protected string $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $path;

    /**
     * @var array of cached Json objects, keyed by filename
     */
    protected array $moduleJson = [];

    /**
     * @var ActivatorInterface
     */
    protected ActivatorInterface $activator;

    protected Translator $lang;

    protected ViewFinderInterface $finder;

    /**
     * @var CacheManager
     */
    private CacheManager $cache;

    /**
     * @var Filesystem
     */
    private Filesystem $files;

    /**
     * @var Router
     */
    private Router $router;

    private UrlGenerator $url;

    /**
     * The constructor.
     *
     * @param ApplicationContract $app
     * @param string $name
     * @param string $path
     */
    public function __construct(
        ApplicationContract $app,
        string $path
    ) {
        $this->path = $path;
        $this->cache = $app['cache'];
        $this->files = $app['files'];
        $this->router = $app['router'];
        $this->finder = $app['view']->getFinder();
        $this->lang = $app['translator'];
        $this->url = $app['url'];
        $this->activator = $app[ActivatorInterface::class];
        $this->app = $app;
        $this->name = $this->getName();
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->get('description');
    }

    /**
     * Get a specific data from json file by given the key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
    {
        return $this->json()->get($key, $default);
    }

    /**
     * Get json contents from the cache, setting as needed.
     *
     * @param string|null $file
     *
     * @return Json
     */
    public function json(string $file = null): Json
    {
        if ($file === null) {
            $file = 'composer.json';
        }

        return Arr::get(
            $this->moduleJson,
            $file,
            function () use ($file) {
                return $this->moduleJson[$file] = new Json($this->getPath().'/'.$file, $this->files);
            }
        );
    }

    /**
     * Get path.
     *
     * @param string $path
     * @return string
     */
    public function getPath(string $path = ''): string
    {
        if ($path) {
            return $this->path .'/'. $path;
        }

        return $this->path;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): Plugin
    {
        $this->path = $path;

        return $this;
    }

    public function getInfo(bool $assoc = false): array|Collection
    {
        $configPath = $this->path . '/composer.json';

        $config = [];

        if (file_exists($configPath)) {
            $config = ReadConfig::load($configPath)->all();
        }

        $config['screenshot'] = $this->getScreenshot();

        $config['path'] = $this->path;

        return $assoc ? $config : new Collection($config);
    }

    /**
     * Get alias.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->get('alias');
    }

    /**
     * Get priority.
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->get('priority');
    }

    /**
     * Get plugin requirements.
     *
     * @return array
     */
    public function getRequires(): array
    {
        return $this->get('require', []);
    }

    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        $domain = $this->getDomainName();
        $name = $this->getName();

        $viewPath = $this->getPath() . '/src/resources/views';
        $langPath = $this->getPath() . '/src/resources/lang';
        $viewPublishPath = resource_path("views/plugins/{$name}");
        $langPublishPath = resource_path("lang/plugins/{$name}");

        if (is_dir($viewPath)) {
            $this->finder->addNamespace($domain, $viewPath);
        }

        if (is_dir($viewPublishPath)) {
            $this->finder->addNamespace($domain, $viewPublishPath);
        }

        if (is_dir($langPath)) {
            $this->lang->addNamespace($domain, $langPath);
        }

        if (is_dir($langPublishPath)) {
            $this->lang->addNamespace($domain, $langPublishPath);
        }

        $this->fireEvent('boot');
    }

    public function getDomainName()
    {
        return $this->getExtraJuzaweb('domain');
    }

    public function getExtraJuzaweb($key, $default = null)
    {
        $extra = $this->get('extra', []);
        if ($laravel = Arr::get($extra, 'juzaweb', [])) {
            return Arr::get($laravel, $key, $default);
        }

        return $default;
    }

    /**
     * Get name plugin.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->json()->get('name');
    }

    /**
     * Get name in lower case.
     *
     * @return string
     */
    public function getLowerName(): string
    {
        return strtolower($this->name);
    }

    /**
     * Get a specific data from composer.json file by given the key.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function getComposerAttr($key, $default = null): mixed
    {
        return $this->json('composer.json')->get($key, $default);
    }

    /**
     * Register the plugin.
     */
    public function register(): void
    {
        $this->registerProviders();

        //$this->registerFiles();

        $adminRouter = $this->getPath() . '/src/routes/admin.php';
        $apiRouter = $this->getPath() . '/src/routes/api.php';
        $webhookRouter = $this->getPath() . '/src/routes/webhook.php';
        $themeRouter = $this->getPath() . '/src/routes/theme.php';

        if (file_exists($adminRouter)) {
            $this->router->middleware('admin')
                ->prefix(config('juzaweb.admin_prefix'))
                ->group($adminRouter);
        }

        if (file_exists($apiRouter)) {
            $this->router->middleware('api')
                ->prefix('api')
                ->as('api.')
                ->group($apiRouter);
        }

        if (file_exists($webhookRouter)) {
            $this->router->prefix('webhook')->as('webhook.')->group($webhookRouter);
        }

        if (file_exists($themeRouter)) {
            $this->router->middleware('theme')->group($themeRouter);
        }

        $this->fireEvent('register');
    }

    /**
     * Register the aliases from this plugin.
     */
    public function registerAliases(): void
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->getExtraJuzaweb('aliases', []) as $aliasName => $aliasClass) {
            $loader->alias($aliasName, $aliasClass);
        }
    }

    /**
     * Register the service providers from this plugin.
     */
    public function registerProviders(): void
    {
        $providers = $this->getExtraJuzaweb('providers', []);

        if (JW_PLUGIN_AUTOLOAD) {
            $providers = array_merge(
                $this->getExtraLarevel('providers', []),
                $providers
            );
        }

        try {
            (new ProviderRepository(
                $this->app,
                new Filesystem(),
                $this->getCachedServicesPath()
            ))
                ->load($providers);
        } catch (\Throwable $e) {
            $this->disable();
            throw $e;
        }
    }

    public function getExtraLarevel($key, $default = null): array
    {
        $extra = $this->get('extra', []);
        if ($laravel = Arr::get($extra, 'laravel', [])) {
            return Arr::get($laravel, $key, $default);
        }

        return $default;
    }

    /**
     * Get the path to the cached *_module.php file.
     */
    public function getCachedServicesPath(): string
    {
        return Str::replaceLast(
            'services.php',
            $this->getSnakeName().'_module.php',
            $this->app->getCachedServicesPath()
        );
    }

    /**
     * Get name in snake case.
     *
     * @return string
     */
    public function getSnakeName(): string
    {
        return namespace_snakename($this->name);
    }

    /**
     * Disable the current plugin.
     */
    public function disable(): void
    {
        $this->fireEvent('disabling');

        $this->activator->disable($this);
        $this->flushCache();

        $this->fireEvent('disabled');
    }

    protected function flushCache(): void
    {
        if (config('plugin.cache.enabled')) {
            $this->cache->store()->flush();
        }
    }

    /**
     * Get name in studly case.
     *
     * @return string
     */
    public function getStudlyName(): string
    {
        $name = explode('/', $this->name);
        $author = Str::studly($name[0]);
        $module = Str::studly($name[1]);
        return $author.'/'.$module;
    }

    /**
     * Determine whether the given status same with the current plugin status.
     *
     * @param bool $status
     *
     * @return bool
     */
    public function isStatus(bool $status): bool
    {
        return $this->activator->hasStatus($this, $status);
    }

    /**
     *  Determine whether the current plugin not disabled.
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }

    /**
     * Determine whether the current plugin activated.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->activator->hasStatus($this, true);
    }

    /**
     * Set active state for current plugin.
     *
     * @param bool $active
     *
     * @return bool
     */
    public function setActive(bool $active): bool
    {
        $this->activator->setActive($this, $active);

        return true;
    }

    /**
     * Enable the current plugin.
     */
    public function enable(): void
    {
        $this->fireEvent('enabling');
        $this->activator->enable($this);
        $this->flushCache();
        $this->runMigrate();
        $this->publishAssets();
        $this->fireEvent('enabled');
    }

    public function publishAssets(): void
    {
        Artisan::call(
            'plugin:publish',
            [
                'module' => $this->get('name'),
            ]
        );
    }

    /**
     * Delete the current plugin.
     *
     * @return bool
     */
    public function delete(): bool
    {
        $this->activator->delete($this);

        return $this->json()->getFilesystem()->deleteDirectory($this->getPath());
    }

    /**
     * Get extra path.
     *
     * @param string $path
     *
     * @return string
     */
    public function getExtraPath(string $path): string
    {
        return $this->getPath().'/'.$path;
    }

    public function getDisplayName()
    {
        $name = $this->getExtraJuzaweb('name');
        if (empty($name)) {
            $name = $this->get('name');
        }

        return $name;
    }

    public function getNamespace()
    {
        $namespace = Arr::get($this->get('autoload', []), 'psr-4');
        $namespace = array_keys($namespace);

        return $namespace[count($namespace) - 1];
    }

    public function getVersion()
    {
        return $this->getExtraJuzaweb('version', 0);
    }

    public function getSettingUrl(): ?string
    {
        return $this->getExtraJuzaweb('setting_url');
    }

    public function asset(string $path, string $default = null): string
    {
        if (str_starts_with($path, 'jw-styles/')) {
            return $this->url->asset($path);
        }

        $path = str_replace('assets/', '', $path);

        $path = $this->getPath("assets/public/{$path}");

        if (file_exists($path)) {
            return $this->url->asset("jw-styles/plugins/{$this->name}/assets/{$path}");
        }

        if ($default) {
            if (is_url($default)) {
                return $default;
            }

            return $this->url->asset($default);
        }

        return $this->url->asset('jw-styles/juzaweb/images/thumb-default.png');
    }

    public function getScreenshot(): ?string
    {
        return $this->asset(
            'images/screenshot.png',
            'jw-styles/juzaweb/images/screenshot.svg'
        );
    }

    public function fileExists(string $path = null): bool
    {
        return file_exists($this->getPath($path));
    }

    public function getContents(string $path): ?string
    {
        if (!$this->fileExists($path)) {
            throw new \Exception("File {$path} not found.");
        }

        return File::get($this->getPath($path));
    }

    public function isVisible(): bool
    {
        return (bool) $this->getExtraJuzaweb('visible', true);
    }

    public function toArray(): array
    {
        return $this->getInfo()->toArray();
    }

    /**
     * Handle call __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getStudlyName();
    }

    /**
     * Register the plugin event.
     *
     * @param string $event
     */
    protected function fireEvent(string $event): void
    {
        $this->app['events']->dispatch(
            sprintf('plugin.%s.'.$event, $this->getLowerName()),
            [$this]
        );
    }

    protected function autoloadPSR4(): void
    {
        $loadmaps = $this->activator->getAutoloadInfo($this);
        $loader = new ClassLoader();

        foreach ($loadmaps as $loadmap) {
            if (empty($loadmap['namespace']) || empty($loadmap['path'])) {
                continue;
            }

            $loader->setPsr4($loadmap['namespace'], [$loadmap['path']]);
        }
        $loader->register(true);
    }

    protected function runMigrate(): void
    {
        Artisan::call(
            'plugin:migrate',
            [
                'module' => $this->name,
                '--force' => true,
            ]
        );
    }

    /**
     * Register the files from this plugin.
     */
    protected function registerFiles(): void
    {
        $files = Arr::get($this->get('autoload', []), 'files', []);
        foreach ($files as $file) {
            include $this->path.'/'.$file;
        }
    }
}
