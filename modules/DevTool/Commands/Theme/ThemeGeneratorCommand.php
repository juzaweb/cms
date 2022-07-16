<?php

namespace Juzaweb\DevTool\Commands\Theme;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ThemeGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Theme Folder Structure';

    /**
     * Theme Folder Path.
     *
     * @var string
     */
    protected string $themePath;

    /**
     * Create Theme Info.
     *
     * @var array
     */
    protected $theme;

    /**
     * Created Theme Structure.
     *
     * @var array
     */
    protected $themeFolders;

    /**
     * Theme Stubs.
     *
     * @var string
     */
    protected string $themeStubPath;

    public function handle()
    {
        $this->themePath = config('juzaweb.theme.path');
        $this->themeFolders = config('theme.stubs.folders');
        $this->theme['name'] = strtolower($this->argument('name'));
        $this->themeStubPath = $this->getThemeStubPath();
        $this->init();
    }

    /**
     * Theme Initialize.
     *
     * @return void
     */
    protected function init(): void
    {
        $createdThemePath = $this->themePath . '/' . $this->theme['name'];

        if (File::isDirectory($createdThemePath)) {
            $this->error('Sorry Boss '. ucfirst($this->theme['name']) .' Theme Folder Already Exist !!!');
            exit();
        }

        $this->generateThemeInfo();

        $themeStubFiles = config('theme.stubs.files');
        $themeStubFiles['theme'] = 'theme.json';
        $themeStubFiles['changelog'] = 'changelog.yml';
        $this->makeDir($createdThemePath);

        foreach ($this->themeFolders as $key => $folder) {
            $this->makeDir($createdThemePath.'/'.$folder);
        }

        $this->createStubs($themeStubFiles, $createdThemePath);

        $this->info(ucfirst($this->theme['name']).' Theme Folder Successfully Generated !!!');
    }

    /**
     * Console command ask questions.
     *
     * @return void
     */
    public function generateThemeInfo(): void
    {
        $this->theme['title'] = Str::ucfirst($this->theme['name']);
        $this->theme['description'] = Str::ucfirst($this->theme['name']) . ' description';
        $this->theme['author'] = 'Author Name';
        $this->theme['version'] = '1.0';
        $this->theme['parent'] = '';
    }

    /**
     * Make directory.
     *
     * @param string $directory
     *
     * @return void
     */
    protected function makeDir(string $directory): void
    {
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Create theme stubs.
     *
     * @param array $themeStubFiles
     * @param string $createdThemePath
     */
    public function createStubs($themeStubFiles, $createdThemePath)
    {
        foreach ($themeStubFiles as $filename => $storePath) {
            if ($filename == 'changelog') {
                $filename = 'changelog' . pathinfo($storePath, PATHINFO_EXTENSION);
            } elseif ($filename == 'theme') {
                $filename = pathinfo($storePath, PATHINFO_EXTENSION);
            } elseif ($filename == 'css' || $filename == 'js') {
                $this->theme[$filename] = ltrim(
                    $storePath,
                    rtrim('assets', '/') . '/'
                );
            }

            $themeStubFile = $this->themeStubPath.'/'.$filename.'.stub';
            $this->makeFile($themeStubFile, $createdThemePath.'/'.$storePath);
        }
    }

    /**
     * Make file.
     *
     * @param string $file
     * @param string $storePath
     *
     * @return void
     */
    protected function makeFile($file, $storePath)
    {
        if (File::exists($file)) {
            $content = $this->replaceStubs(File::get($file));
            File::put($storePath, $content);
        }
    }

    /**
     * Replace Stub string.
     *
     * @param string $contents
     *
     * @return string
     */
    protected function replaceStubs($contents)
    {
        $mainString = [
            '[NAME]',
            '[TITLE]',
            '[DESCRIPTION]',
            '[AUTHOR]',
            '[PARENT]',
            '[VERSION]',
            '[CSSNAME]',
            '[JSNAME]',
        ];
        $replaceString = [
            $this->theme['name'],
            $this->theme['title'],
            $this->theme['description'],
            $this->theme['author'],
            $this->theme['parent'],
            $this->theme['version'],
        ];

        return str_replace($mainString, $replaceString, $contents);
    }

    protected function getThemeStubPath(): string
    {
        return __DIR__ . '/../../stubs/theme';
    }
}
