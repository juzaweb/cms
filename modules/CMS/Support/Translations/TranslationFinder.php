<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Translations;

use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\TranslationFinder as TranslationFinderContract;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TranslationFinder implements TranslationFinderContract
{
    public function find(string $path, string $locale = 'en'): array
    {
        $groupKeys = [];
        $stringKeys = [];
        $functions = [
            'trans',
            'trans_choice',
            'Lang::get',
            'Lang::choice',
            'Lang::trans',
            'Lang::transChoice',
            '@lang',
            '@choice',
            '__',
            '$trans.get',
        ];

        $groupPattern =                          // See https://regex101.com/r/WEJqdL/6
            "[^\w|>]" .                          // Must not have an alphanum or _ or > before real method
            '(' . implode('|', $functions) . ')' .  // Must start with one of the functions
            "\(" .                               // Match opening parenthesis
            "[\'\"]" .                           // Match " or '
            '(' .                                // Start a new group to match:
            '[\/a-zA-Z0-9\_\-\:]+' .                 // Must start with group
            "([.](?! )[^\1)]+)+" .               // Be followed by one or more items/keys
            ')' .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                             // Close parentheses or new parameter

        $stringPattern = "[^\w]".                                     // Must not have an alphanum before real method
            '('.implode('|', $functions).')'.             // Must start with one of the functions
            "\(\s*".                                       // Match opening parenthesis
            "(?P<quote>['\"])".                            // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)". // Match any string that can be {quote} escaped
            "\k{quote}".                                   // Match " or ' previously matched
            "\s*[\),]";                                    // Close parentheses or new parameter

        // Find all PHP + Twig files in the app folder, except for storage
        $finder = new Finder();
        $finder->in($path)
            ->exclude('storage')
            ->exclude('vendor')
            ->name('*.php')
            ->name('*.twig')
            ->name('*.vue')
            ->files();

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            // Search the current file for the pattern
            if (preg_match_all("/{$groupPattern}/siU", $file->getContents(), $matches)) {
                // Get all matches
                foreach ($matches[2] as $key) {
                    $groupKeys[] = $key;
                }
            }

            if (preg_match_all("/$stringPattern/siU", $file->getContents(), $matches)) {
                foreach ($matches['string'] as $key) {
                    if (preg_match(
                        "/(^[\/a-zA-Z0-9_-]+([.][^\1)\ ]+)+$)/siU",
                        $key,
                        $groupMatches
                    )
                    ) {
                        // group{.group}.key format, already in $groupKeys but also matched here
                        // do nothing, it has to be treated as a group
                        continue;
                    }

                    //TODO: This can probably be done in the regex, but I couldn't do it.
                    //skip keys which contain namespacing characters, unless they also contain a
                    //space, which makes it JSON.
                    if (!(Str::contains($key, '::') && Str::contains($key, '.'))
                        || Str::contains($key, ' ')
                    ) {
                        $stringKeys[] = $key;
                    }
                }
            }
        }

        // Remove duplicates
        $groupKeys = array_unique($groupKeys);
        $stringKeys = array_unique($stringKeys);

        $results = [];
        // Add the translations to the database, if not existing.
        foreach ($groupKeys as $key) {
            // Split the group and item
            list($group, $item) = explode('.', $key, 2);
            $namespace = '*';
            if (Str::contains($key, '::')) {
                $namespace = explode('::', $key)[0];
                $group = str_replace("{$namespace}::", '', $group);
            }

            $value = Str::ucfirst(str_replace(["{$namespace}::", "{$group}.", '.', '_'], ['', '', ' ', ' '], $key));

            $results[] = [
                'namespace' => $namespace,
                'locale' => $locale,
                'group' => $group,
                'key' => $item,
                'value' => $value,
            ];
        }

        foreach ($stringKeys as $key) {
            $namespace = '*';
            $group = '*';

            $results[] = [
                'namespace' => $namespace,
                'locale' => $locale,
                'group' => $group,
                'key' => $key,
                'value' => $key,
            ];
        }

        return $results;
    }
}
