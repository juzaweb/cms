<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Translations;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Models\Translation;
use Symfony\Component\Finder\SplFileInfo;

class TranslationExporter
{
    protected string $language;

    public function __construct(
        protected Collection $module
    ) {
    }

    public function run(): int
    {
        $path = $this->module->get('lang_path');
        $enFiles = File::files("{$path}/en");
        $groups = collect($enFiles)->map(fn (SplFileInfo $file) => $file->getFilenameWithoutExtension())->toArray();

        if (!is_dir("{$path}/{$this->language}")) {
            mkdir("{$path}/{$this->language}");
        }

        foreach ($groups as $group) {
            $current = [];
            $fileLang = "{$path}/{$this->language}/{$group}.php";
            if (file_exists($fileLang)) {
                $current = include $fileLang;
            }

            $trans = Translation::where('locale', '=', $this->language)
                ->where('namespace', '=', $this->module->get('namespace'))
                ->where('group', '=', $group)
                ->get()
                ->mapWithKeys(
                    function ($item) {
                        return [$item->key => $item->value];
                    }
                )->toArray();

            if (empty($trans)) {
                continue;
            }

            $trans = $this->parseChildKeyArray($trans);
            $trans = array_merge($trans, $current);

            $str = '<?php' . PHP_EOL . 'return ' . $this->varExport($trans) . ';' . PHP_EOL;
            File::put("{$path}/{$this->language}/{$group}.php", $str);
        }
    }

    protected function parseChildKeyArray(array $data): array
    {
        $result = [];
        foreach ($data as $key => $item) {
            Arr::set($result, $key, $item);
        }

        return $result;
    }

    protected function varExport($expression): string
    {
        $export = var_export($expression, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(
            ["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"],
            [null, ']$1', ' => ['],
            $array
        );
        return join(PHP_EOL, array_filter(["["] + $array));
    }
}
