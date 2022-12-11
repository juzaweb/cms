<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Support\Collection;
use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\API\Support\Swagger\SwaggerVersion;

/**
 * @see \Juzaweb\CMS\Support\HookAction
 * @see \Juzaweb\CMS\Traits\HookAction\RegisterHookAction
 * @see \Juzaweb\CMS\Traits\HookAction\GetHookAction
 */
interface HookActionContract
{
    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void;
    
    public function addFilter($tag, $callback, $priority = 20, $arguments = 1): void;
    
    public function registerPostType(string $key, array $args = []): void;
    
    public function registerTaxonomy(string $taxonomy, array|string $objectType, array $args = []): void;
    
    public function registerResource(string $key, ?string $postType = null, ?array $args = []): void;
    
    public function registerMenuBox(string $key, array $args = []): void;
    
    public function registerPermalink(string $key, array $args = []): void;
    
    /**
     * @param  string  $key
     * @param  array  $args  [string $name]
     */
    public function addSettingForm(string $key, array $args = []): void;
    
    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void;
    
    public function addMasterAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void;
    
    public function addThumbnailSizes(string $postType, string|array $size): void;
    
    public function applyFilters(string $tag, mixed $value, ...$args): mixed;
    
    public function getMenuBoxs(array $keys = []): array;
    
    public function enqueueScript(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void;
    
    public function enqueueStyle(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void;
    
    public function enqueueFrontendScript(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void;
    
    public function enqueueFrontendStyle(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void;
    
    public function getProfilePages($key = null): Collection;
    
    public function registerPermission(string $key, array $args = []): void;
    
    public function registerResourcePermissions(string $resource, string $name): void;
    
    /**
     * Register config keys
     *
     * @param  array|string  $key
     * @param  array  $args
     */
    public function registerConfig(array|string $key, array $args = []): void;
    
    public function getPermissions(string $key = null): Collection;
    
    public function getConfigs($key = null): Collection;
    
    public function getTaxonomies($postType = null): Collection;
    
    public function addMetaPostTypes(string $postType, array $metas): void;
    
    public function registerEmailTemplate(string $key, array $args = []): void;
    
    public function getThumbnailSizes($postType = null): Collection;
    
    public function getPostTypes(string $postType = null): Collection;
    
    public function getEmailTemplates(string $key = null): ?Collection;
    
    /**
     * Register Admin Page
     *
     * @param  string  $key
     * @param  array  $args
     * @return void
     */
    public function registerAdminPage(string $key, array $args): void;
    
    public function getAPIDocuments(string $key = null): null|Collection|SwaggerDocument;
    
    public function getDataByKey(string $dataKey, string $key = null): ?Collection;
}
