<?php

namespace Juzaweb\CMS\Support\Generators;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command as Console;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\ActivatorInterface;
use Juzaweb\CMS\Support\Config\GenerateConfigReader;
use Juzaweb\CMS\Support\LocalPluginRepository;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Support\Stub;

class ModuleGenerator extends Generator
{
    /**
     * The plugin name will create.
     *
     * @var string
     */
    protected string $name;

    /**
     * The laravel config instance.
     *
     * @var ?Config
     */
    protected ?Config $config;

    /**
     * The laravel filesystem instance.
     *
     * @var ?Filesystem
     */
    protected ?Filesystem $filesystem;

    /**
     * The laravel console instance.
     *
     * @var ?Console
     */
    protected ?Console $console;

    /**
     * The activator instance
     *
     * @var ?ActivatorInterface
     */
    protected ?ActivatorInterface $activator;

    /**
     * The plugin instance.
     *
     * @var \Juzaweb\CMS\Support\Plugin|LocalPluginRepository|null
     */
    protected Plugin|null|LocalPluginRepository $module;

    /**
     * Force status.
     *
     * @var bool
     */
    protected bool $force = false;

    /**
     * Generate a plain plugin.
     *
     * @var bool
     */
    protected bool $plain = false;

    /**
     * Enables the plugin.
     *
     * @var bool
     */
    protected bool $isActive = false;

    protected ?string $title;

    protected ?string $description;

    protected ?string $author;

    protected ?string $domain;

    protected ?string $version;

    protected ?string $cmsMinVersion;

    /**
     * The constructor.
     * @param $name
     * @param LocalPluginRepository|null $module
     * @param Config|null $config
     * @param Filesystem|null $filesystem
     * @param Console|null $console
     * @param ActivatorInterface|null $activator
     */
    public function __construct(
        $name,
        LocalPluginRepository $module = null,
        Config $config = null,
        Filesystem $filesystem = null,
        Console $console = null,
        ActivatorInterface $activator = null
    ) {
        $this->name = $name;
        $this->config = $config;
        $this->filesystem = $filesystem;
        $this->console = $console;
        $this->module = $module;
        $this->activator = $activator;
    }

    /**
     * Set plain flag.
     *
     * @param bool $plain
     *
     * @return $this
     */
    public function setPlain($plain): static
    {
        $this->plain = $plain;

        return $this;
    }

    /**
     * Set active flag.
     *
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active): static
    {
        $this->isActive = $active;

        return $this;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setAuthor(?string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function setDomain(?string $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    public function setVersion(?string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function setCmsMinVersion(?string $cmsMinVersion): static
    {
        $this->cmsMinVersion = $cmsMinVersion;

        return $this;
    }

    /**
     * Get the name of plugin will create. By default, in studly case.
     *
     * @return string
     */
    public function getName(): string
    {
        return Str::lower($this->name);
    }

    public function getStudlyName(): string
    {
        $name = explode('/', $this->name);
        $name = $name[1] ?? $name[0];

        return Str::studly($name);
    }

    public function getSnakeName(): string
    {
        return Str::snake(preg_replace('/[^0-9a-z]/', '_', $this->name));
    }

    /**
     * Get the laravel config instance.
     *
     * @return Config
     */
    public function getConfig(): ?Config
    {
        return $this->config;
    }

    /**
     * Set the laravel config instance.
     *
     * @param  Config  $config
     *
     * @return $this
     */
    public function setConfig(Config $config): static
    {
        $this->config = $config;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title ?? $this->getStudlyName();
    }

    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    public function getAuthor(): string
    {
        return $this->author ?? '';
    }

    public function getDomain(): string
    {
        return $this->domain ?? $this->generateDomain();
    }

    public function getVersion(): string
    {
        return $this->version ?? '1.0';
    }

    public function getCmsMinVersion(): string
    {
        return $this->cmsMinVersion ?? '3.3';
    }

    /**
     * Set the plugins activator
     *
     * @param ActivatorInterface $activator
     *
     * @return $this
     */
    public function setActivator(ActivatorInterface $activator): static
    {
        $this->activator = $activator;

        return $this;
    }

    /**
     * Get the laravel filesystem instance.
     *
     * @return Filesystem
     */
    public function getFilesystem(): ?Filesystem
    {
        return $this->filesystem;
    }

    /**
     * Set the laravel filesystem instance.
     *
     * @param Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem($filesystem): static
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get the laravel console instance.
     *
     * @return Console
     */
    public function getConsole(): ?Console
    {
        return $this->console;
    }

    /**
     * Set the laravel console instance.
     *
     * @param Console $console
     *
     * @return $this
     */
    public function setConsole($console): static
    {
        $this->console = $console;

        return $this;
    }

    /**
     * Get the plugin instance.
     *
     * @return LocalPluginRepository|Plugin|null
     */
    public function getModule(): LocalPluginRepository|\Juzaweb\CMS\Support\Plugin|null
    {
        return $this->module;
    }

    /**
     * Set the plugin instance.
     *
     * @param mixed $module
     *
     * @return $this
     */
    public function setModule($module): static
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get the list of folders will created.
     *
     * @return array
     */
    public function getFolders(): array
    {
        return $this->module->config('paths.generator');
    }

    /**
     * Get the list of files will create.
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->module->config('stubs.files');
    }

    /**
     * Set force status.
     *
     * @param bool|int $force
     *
     * @return $this
     */
    public function setForce($force): static
    {
        $this->force = $force;

        return $this;
    }

    /**
     * Generate the plugin.
     */
    public function generate(): void
    {
        $name = $this->getName();

        if ($this->module->has($name)) {
            if ($this->force) {
                $this->module->delete($name);
            } else {
                $this->console->error("Plugin [{$name}] already exist!");
                return;
            }
        }

        $this->generateFolders();

        //$this->generateModuleJsonFile();

        if ($this->plain !== true) {
            $this->generateFiles();
            $this->generateResources();
        }

        /*if ($this->plain === true) {
            $this->cleanModuleJsonFile();
        }*/

        $this->console->info("Plugin [{$name}] created successfully.");

        $this->activator->setActiveByName($name, $this->isActive);

        $this->console->info("Plugin [{$name}] is actived.");
    }

    /**
     * Generate the folders.
     */
    public function generateFolders(): void
    {
        foreach ($this->getFolders() as $key => $folder) {
            $folder = GenerateConfigReader::read($key);

            if ($folder->generate() === false) {
                continue;
            }

            $path = $this->module->getModulePath($this->getName()) . $folder->getPath();

            if ($this->filesystem->isDirectory($path)) {
                continue;
            }

            $this->filesystem->makeDirectory($path, 0755, true);

            $this->generateGitKeep($path);
        }
    }

    /**
     * Generate git keep to the specified path.
     *
     * @param string $path
     */
    public function generateGitKeep($path): void
    {
        $this->filesystem->put($path . '/.gitkeep', '');
    }

    /**
     * Generate the files.
     */
    public function generateFiles(): void
    {
        foreach ($this->getFiles() as $stub => $file) {
            $path = $this->module->getModulePath($this->getName()) . $file;

            if (! $this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0775, true);
            }

            $this->filesystem->put($path, $this->getStubContents($stub));

            $path = realpath($path);
            $this->console->info("Created : {$path}");
        }
    }

    /**
     * Generate some resources.
     */
    public function generateResources(): void
    {
        if (GenerateConfigReader::read('seeder')->generate() === true) {
            $this->console->call(
                'plugin:make-seed',
                [
                    'name' => $this->getStudlyName(),
                    'module' => $this->getName(),
                    '--master' => true,
                ]
            );
        }

        if (GenerateConfigReader::read('provider')->generate() === true) {
            $this->console->call(
                'plugin:make-provider',
                [
                    'name' => $this->getStudlyName() . 'ServiceProvider',
                    'module' => $this->getName(),
                    '--master' => true,
                ]
            );
            /*$this->console->call('plugin:route-provider', [
                'module' => $this->getName(),
            ]);*/
        }

        if (GenerateConfigReader::read('controller')->generate() === true) {
            $this->console->call(
                'plugin:make-controller',
                [
                    'controller' => $this->getStudlyName() . 'Controller',
                    'module' => $this->getName(),
                ]
            );
        }
    }

    /**
     * get the list for the replacements.
     */
    public function getReplacements()
    {
        return $this->module->config('stubs.replacements');
    }

    /**
     * Get the contents of the specified stub file by given stub name.
     *
     * @param $stub
     *
     * @return string
     */
    protected function getStubContents($stub): string
    {
        return (new Stub(
            '/' . $stub . '.stub',
            $this->getReplacement($stub)
        )
        )->render();
    }

    /**
     * Get array replacement for the specified stub.
     *
     * @param $stub
     *
     * @return array
     */
    protected function getReplacement($stub)
    {
        $replacements = $this->getReplacements();

        if (! isset($replacements[$stub])) {
            return [];
        }

        $keys = $replacements[$stub];

        $replaces = [];

        if ($stub === 'json' || $stub === 'composer') {
            if (in_array('PROVIDER_NAMESPACE', $keys, true) === false) {
                $keys[] = 'PROVIDER_NAMESPACE';
            }
        }

        foreach ($keys as $key) {
            if (method_exists($this, $method = 'get' . ucfirst(Str::studly(strtolower($key))) . 'Replacement')) {
                $replaces[$key] = $this->$method();
            } else {
                $replaces[$key] = null;
            }
        }

        /*if ($stub === 'composer') {
            dd($replaces);
        }*/

        return $replaces;
    }

    /**
     * Generate the config.json file
     */
    private function generateModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getName()) . 'config.json';

        if (! $this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0775, true);
        }

        $this->filesystem->put($path, $this->getStubContents('json'));

        $this->console->info("Created : {$path}");
    }

    /**
     * Remove the default service provider that was added in the config.json file
     * This is needed when a --plain plugin was created
     */
    private function cleanModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getName()) . 'config.json';
        $content = $this->filesystem->get($path);
        $namespace = $this->getModuleNamespaceReplacement();
        $studlyName = $this->getStudlyNameReplacement();
        $provider = '"' . $namespace . '\\\\' . $studlyName . '\\\\Providers\\\\' . $studlyName . 'ServiceProvider"';
        $content = str_replace($provider, '', $content);
        $this->filesystem->put($path, $content);
    }

    /**
     * Get the plugin name in lower case.
     *
     * @return string
     */
    protected function getLowerNameReplacement(): string
    {
        return strtolower($this->getName());
    }

    /**
     * Get the plugin name in studly case.
     *
     * @return string
     */
    protected function getStudlyNameReplacement(): string
    {
        return $this->getName();
    }

    /**
     * Get the plugin name in snake case.
     *
     * @return string
     */
    protected function getSnakeNameReplacement(): string
    {
        return strtolower($this->getSnakeName());
    }

    /**
     * Get replacement for $VENDOR$.
     *
     * @return string
     */
    protected function getVendorReplacement(): string
    {
        $name = explode('/', $this->getName());

        return $name[0];
    }

    /**
     * Get replacement for $MODULE_NAMESPACE$.
     *
     * @return string
     */
    protected function getModuleNamespaceReplacement(): string
    {
        $name = $this->getName();
        $namespace = ucwords(str_replace('/', ' ', $name));
        $namespace = str_replace(' ', '\\', $namespace);
        $namespace = ucwords(str_replace('-', ' ', $namespace));
        $namespace = str_replace(' ', '', $namespace);
        return str_replace('\\', '\\\\', $namespace);
    }

    /**
     * Get replacement for $MODULE_NAME$.
     *
     * @return string
     */
    protected function getModuleNameReplacement(): string
    {
        $name = explode('\\', $this->getModuleNamespaceReplacement());
        return $name[count($name) - 1];
    }

    /**
     * Get replacement for $AUTHOR_NAME$.
     *
     * @return string
     */
    protected function getAuthorNameReplacement(): string
    {
        $name = explode('/', $this->getName());
        return ucfirst($name[0]);
    }

    /**
     * Get replacement for $AUTHOR_EMAIL$.
     *
     * @return string
     */
    protected function getAuthorEmailReplacement(): string
    {
        return 'example@gmail.com';
    }

    protected function getProviderNamespaceReplacement(): string
    {
        return 'Providers';
    }

    protected function getModuleDomainReplacement(): string
    {
        return $this->getDomain();
    }

    protected function getTitleReplacement(): string
    {
        return $this->getTitle();
    }

    protected function getDescriptionReplacement(): string
    {
        return $this->getDescription();
    }

    protected function getAuthorReplacement(): string
    {
        return $this->getAuthor();
    }

    protected function getVersionReplacement(): string
    {
        return $this->getVersion();
    }

    protected function getCmsMinVersionReplacement(): string
    {
        return $this->getCmsMinVersion();
    }

    protected function generateDomain(): string
    {
        [$author, $plugin] = explode('/', $this->getName());

        return substr($author, 0, 2) . substr($plugin, 0, 2);
    }
}
