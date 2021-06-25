<?php

namespace Mymo\Theme\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
    protected $themePath;

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
    protected $themeStubPath;

    /**
     * Execute the console command.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->themePath = config('mymo.theme.path');
        $this->theme['name'] = strtolower($this->argument('name'));
        $this->init();
    }

    /**
     * Theme Initialize.
     *
     * @return void
     */
    protected function init()
    {
        $createdThemePath = $this->themePath . '/' . $this->theme['name'];

        if (File::isDirectory($createdThemePath)) {
            $this->error('Sorry Boss '. ucfirst($this->theme['name']) .' Theme Folder Already Exist !!!');
            exit();
        }

        $this->generateThemeInfo();
        $this->themeFolders = $this->getThemeFolders();
        $this->themeStubPath = $this->getThemeStubPath();
        $themeStubFiles = $this->getThemeStubFiles();
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
    public function generateThemeInfo()
    {
        $this->theme['title'] = Str::ucfirst($this->theme['name']);
        $this->theme['description'] = Str::ucfirst($this->theme['name']) . ' description';
        $this->theme['author'] = 'Author Name';
        $this->theme['version'] = '1.0';
        $this->theme['parent'] = '';
        $this->theme['css'] = '';
        $this->theme['js'] = '';
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
     * Make directory.
     *
     * @param string $directory
     *
     * @return void
     */
    protected function makeDir($directory)
    {
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
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
            $this->theme['css'],
            $this->theme['js'],
        ];

        $replaceContents = str_replace($mainString, $replaceString, $contents);
        return $replaceContents;
    }

    protected function getThemeStubPath()
    {
        return __DIR__ . '/../../../stubs/theme';
    }

    protected function getThemeStubFiles()
    {
        return [
            'css'    => 'assets/css/app.css',
            'layout' => 'views/layouts/master.blade.php',
            'page'   => 'views/welcome.blade.php',
            'lang'   => 'lang/en/content.php',
        ];
    }

    protected function getThemeFolders()
    {
        return [
            'assets'  => 'assets',
            'views'   => 'views',
            'lang'    => 'lang',
            'lang/en' => 'lang/en',
            'css' => 'assets/css',
            'js'  => 'assets/js',
            'img' => 'assets/images',
            'layouts' => 'views/layouts',
        ];
    }
}
