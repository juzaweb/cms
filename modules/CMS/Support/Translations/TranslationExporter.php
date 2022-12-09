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

class TranslationExporter
{
    protected string $language;
    protected bool $force = false;

    public function __construct(
        protected Collection $module
    ) {
    }

    public function run(): int
    {
        if (isset($this->language)) {
            return $this->exportLanguage($this->language);
        }

        $languages = Translation::where(
            [
                'object_type' => $this->module->get('type'),
                'object_key' => $this->module->get('key'),
            ]
        )->groupBy('locale')
            ->get(['locale'])
            ->pluck('locale')
            ->toArray();

        $total = 0;
        foreach ($languages as $language) {
            $total += $this->exportLanguage($language);
        }

        return $total;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function setForce(bool $force): static
    {
        $this->force = $force;

        return $this;
    }

    protected function exportLanguage(string $language): int
    {
        $path = $this->module->get('lang_path');
        $groups = $this->getModuleGroups();

        if (!is_dir("{$path}/{$language}")) {
            mkdir("{$path}/{$language}");
        }

        $total = 0;
        foreach ($groups as $group) {
            $current = [];
            $fileLang = "{$path}/{$language}/{$group}.php";
            if (file_exists($fileLang)) {
                $current = include $fileLang;
            }

            $trans = Translation::where(
                [
                    'object_type' => $this->module->get('type'),
                    'object_key' => $this->module->get('key'),
                ]
            )
                ->where('locale', '=', $language)
                ->where('namespace', '=', $this->module->get('namespace'))
                ->where('group', '=', $group)
                ->get()
                ->mapWithKeys(fn ($item) => [$item->key => $item->value])
                ->toArray();

            if (empty($trans)) {
                continue;
            }

            $trans = $this->parseChildKeyArray($trans);
            if ($this->force) {
                $trans = array_merge_recursive($trans, $current);
            } else {
                $trans = array_merge_recursive($current, $trans);
            }

            $str = '<?php' . PHP_EOL . 'return ' . $this->varExport($trans) . ';' . PHP_EOL;
            File::put("{$path}/{$language}/{$group}.php", $str);
            $total += 1;
        }

        return $total;
    }

    protected function getModuleGroups(): array
    {
        $query = Translation::where(
            [
                'object_type' => $this->module->get('type'),
                'object_key' => $this->module->get('key'),
            ]
        )->groupBy('group');

        if ($this->module->get('type') != 'theme') {
            $query->where('group', '!=', '*');
        }

        return $query->get(['group'])->pluck('group')->toArray();
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
