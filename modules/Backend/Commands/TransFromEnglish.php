<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Models\Translation;
use Juzaweb\CMS\Support\GoogleTranslate;
use Symfony\Component\Finder\SplFileInfo;

class TransFromEnglish extends TranslationCommand
{
    protected $name = 'trans:generate-translate';
    private array $targetDefaults = ['vi', 'fr', 'tr', 'zh', 'ru', 'ko', 'ja'];

    public function handle(): int
    {
        $this->translateDefaults();

        $this->transToFile();

        return self::SUCCESS;
    }

    protected function translateDefaults()
    {
        foreach ($this->targetDefaults as $language) {
            $this->translationWithGoogle('en', $language);
        }
    }

    protected function translationWithGoogle($source, $target)
    {
        $trans = Translation::from('jw_translations AS a')
            ->where('locale', '=', 'en')
            ->where('namespace', '=', 'cms')
            ->whereNotExists(
                function (Builder $q) use ($target) {
                    $q->select(['id'])
                        ->from('jw_translations AS b')
                        ->where('locale', '=', $target)
                        ->whereColumn('a.group', '=', 'b.group')
                        ->whereColumn('a.namespace', '=', 'b.namespace')
                        ->whereColumn('a.key', '=', 'b.key')
                        ->whereColumn('a.object_type', '=', 'b.object_type')
                        ->whereColumn('a.object_key', '=', 'b.object_key');
                }
            )
            ->get();

        foreach ($trans as $tran) {
            $value = GoogleTranslate::translate(
                $source,
                $target,
                $tran->value
            );

            if (empty($value)) {
                $this->error("Translate {$tran->value} fail");
                die();
            }

            $newTran = Translation::firstOrCreate(
                [
                    'locale' => $target,
                    'group' => $tran->group,
                    'namespace' => $tran->namespace,
                    'key' => $tran->key,
                    'object_type' => $tran->object_type,
                    'object_key' => $tran->object_key,
                ],
                [
                    'value' => $value
                ]
            );

            if ($newTran->wasRecentlyCreated) {
                $this->info("Translated {$tran->value} to {$newTran->value}");
            }

            sleep(1);
        }
    }

    protected function transToFile()
    {
        $objects = $this->allObjects();
        $languages = ['vi', 'fr', 'tr', 'zh', 'ru', 'ko', 'ja'];

        foreach ($objects as $key => $object) {
            if ($key != 'core') {
                continue;
            }

            foreach ($languages as $language) {
                $path = $object->get('path');
                $enFiles = File::files("{$path}/en");
                $groups = collect($enFiles)->map(
                    function (SplFileInfo $file) {
                        return str_replace('.php', '', $file->getFilename());
                    }
                )
                    ->toArray();

                if (!is_dir("{$path}/{$language}")) {
                    mkdir("{$path}/{$language}");
                }

                foreach ($groups as $group) {
                    $current = [];
                    $fileLang = "{$path}/{$language}/{$group}.php";
                    if (file_exists($fileLang)) {
                        $current = include $fileLang;
                    }

                    $trans = Translation::where('locale', '=', $language)
                        ->where('namespace', '=', $object->get('namespace'))
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
                    File::put("{$path}/{$language}/{$group}.php", $str);
                }
            }
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

    protected function getArguments(): array
    {
        return [];
    }
}
