<?php

namespace Spatie\TranslationLoader;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * Spatie\TranslationLoader\LanguageLine
 *
 * @property int $id
 * @property string $group
 * @property string $key
 * @property array $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereUpdatedAt($value)
 * @property string $namespace
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageLine whereNamespace($value)
 */
class LanguageLine extends Model
{
    protected $table = 'language_lines';
    /** @var array */
    public $translatable = ['text'];

    /** @var array */
    public $guarded = ['id'];

    /** @var array */
    protected $casts = [
        'text' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        $flushGroupCache = function (self $languageLine) {
            $languageLine->flushGroupCache();
        };

        static::saved($flushGroupCache);
        static::deleted($flushGroupCache);
    }

    public static function getTranslationsForGroup(string $locale, string $group, $namespace = null): array
    {
        return Cache::store('file')
            ->rememberForever(
                static::getCacheKey($group, $locale, $namespace),
                function () use ($group, $locale, $namespace) {
                    return static::query()
                        ->where('group', $group)
                        ->where('namespace', $namespace)
                        ->get()
                        ->reduce(function ($lines, self $languageLine) use ($group, $locale) {
                            $translation = $languageLine->getTranslation($locale);

                            if ($translation !== null && $group === '*') {
                                // Make a flat array when returning json translations
                                $lines[$languageLine->key] = $translation;
                            } elseif ($translation !== null && $group !== '*') {
                                // Make a nesetd array when returning normal translations
                                Arr::set($lines, $languageLine->key, $translation);
                            }

                            return $lines;
                        }) ?? [];
                }
            );
    }

    public static function getCacheKey(string $group, string $locale, $namespace): string
    {
        global $site;

        return "translation-loader.". $site->id .".{$group}.{$locale}.{$namespace}";
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getTranslation(string $locale): ?string
    {
        if (! isset($this->text[$locale])) {
            $fallback = config('app.fallback_locale');

            return $this->text[$fallback] ?? null;
        }

        return $this->text[$locale];
    }

    /**
     * @param string $locale
     * @param string $value
     *
     * @return $this
     */
    public function setTranslation(string $locale, string $value)
    {
        $this->text = array_merge($this->text ?? [], [$locale => $value]);

        return $this;
    }

    public function flushGroupCache()
    {
        foreach ($this->getTranslatedLocales() as $locale) {
            Cache::store('file')->forget(
                static::getCacheKey(
                    $this->group,
                    $locale,
                    $this->namespace
                )
            );
        }
    }

    protected function getTranslatedLocales(): array
    {
        return array_keys($this->text);
    }
}
