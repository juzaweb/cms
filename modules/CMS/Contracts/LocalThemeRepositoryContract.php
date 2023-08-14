<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Inertia\Response;
use Juzaweb\CMS\Exceptions\ThemeNotFoundException;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;
use Juzaweb\CMS\Support\LocalThemeRepository;

/**
* @see LocalThemeRepository
 */
interface LocalThemeRepositoryContract
{
    /**
     * Get all theme information.
     *
     * @param bool $collection
     * @return array|Collection
     */
    public function scan(bool $collection = false): array|Collection;

     /**
     * Find a theme by name.
     *
     * @param string $name The name of the theme to find.
     * @return ThemeInterface|null The theme object if found, null otherwise.
     */
    public function find(string $name): ?ThemeInterface;

    /**
     * Find a specific module, if there return that, otherwise throw exception.
     *
     * @param string $name
     *
     * @return ThemeInterface
     *
     * @throws ThemeNotFoundException
     */
    public function findOrFail(string $name): ThemeInterface;

     /**
     * Retrieves all items from the collection.
     *
     * @param bool $collection Determines if the items should be returned as a collection.
     * @return array|Collection The scanned items.
     */
    public function all(bool $collection = false): array|Collection;

    /**
     * Retrieves the current theme.
     *
     * @return ThemeInterface The current theme.
     */
    public function currentTheme(): ThemeInterface;

    public function has(string $name): bool;

    /**
     * Deletes a theme by name.
     *
     * @param string $name The name of the theme to delete.
     * @return bool True if the theme was successfully deleted, false otherwise.
     */
    public function delete(string $name): bool;

    public function render(string $view, array $params = [], ?string $theme = null): Factory|View|string|Response;

    public function parseParam(mixed $param, ?string $theme = null): mixed;
}
