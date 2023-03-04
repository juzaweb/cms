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

use Exception;
use Illuminate\Support\Collection;
use Juzaweb\API\Support\Swagger\SwaggerDocument;

/**
 * @see \Juzaweb\CMS\Support\HookAction
 * @see \Juzaweb\CMS\Traits\HookAction\RegisterHookAction
 * @see \Juzaweb\CMS\Traits\HookAction\GetHookAction
 */
interface HookActionContract
{
    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void;

    public function addFilter($tag, $callback, $priority = 20, $arguments = 1): void;

    /**
     * Registers a post type.
     *
     * @param string $key (Required) Post type key. Must not exceed 20 characters
     * @param array $args Array of arguments for registering a post type.
     * - 'model' (string): The class name of the model to associate the post type with,
     * eg. \App\Models\Post::class (defaults to the Post model).
     * - 'description' (string): A description for the post type (optional).
     * - 'priority' (int): Specify the priority in which the post type will show on the admin page (defaults to 20).
     * - 'show_in_menu' (bool): This will determine whether the post type appears in the main navigation menu
     * on the dashboard.
     * - 'rewrite' (bool): If this is set to true the post type will have its own permalink structure (optional).
     * - 'taxonomy_rewrite' (bool): This will determine whether custom taxonomies associated with this post type will
     * have their own rewrites or use the default rewrite mechanism.
     * - 'menu_box' (bool): Decide if a menu box should be displayed in the admin menu for this post type (optional).
     * - 'menu_position' (int): Specify the position in the menu that the post type should appear at (optional).
     * - 'callback' (string): Provide the class name of a controller that will handle requests related to
     * this post type (optional).
     * - 'menu_icon' (string): Specify a font-awesome icon to use for the post type menu icon (optional).
     * - 'supports' (array): An array of features the post type should support,
     * such as 'comment', 'author' etc. (optional).
     * - 'metas' (array): A list of custom meta fields available when editing the post (optional).
     *
     * @throws Exception
     */
    public function registerPostType(string $key, array $args = []): void;

    /**
     * Register a new permalink.
     *
     * @param string $key The key of the permalink.
     * @param array $args Additional arguments for the permalink.
     * Must contain 'label' and 'base' keys (both required). Optional keys are 'callback', 'post_type', and 'position'.
     *
     * @throws Exception Thrown if label or base args are missing.
     */
    public function registerPermalink(string $key, array $args = []): void;

    /**
     * Creates or modifies a taxonomy object.
     *
     * @param string $taxonomy (Required) Taxonomy key, must not exceed 32 characters.
     * @param array|string $objectType
     * @param array $args (Optional) Array of arguments for registering a post type.
     * @return void
     *
     * @throws Exception
     */
    public function registerTaxonomy(string $taxonomy, array|string $objectType, array $args = []): void;

    /**
     * Register a new resource
     *
     * @param string $key Unique key of the resource
     * @param string|null $postType Post type associated with the resource
     * @param array|null $args Arguments associated with the resource
     */
    public function registerResource(string $key, ?string $postType = null, ?array $args = []): void;

    /**
     * Register a menu box.
     *
     * @param string $key Unique identifier for the menu box.
     *
     * @param array $args { Configuration options for the menu box; all options are optional,
     * and some can be further customized via specific methods.
     * @type string $title The title (label) of the menu box.
     * @type string $key Unique identifier for the menu box.
     * @type string $group The group the menu box should be attached to.
     * @type string $menu_box A function that returns the content of the menu box.
     * @type integer $priority The priority of the menu box with respect to other menu boxes on the same page.
     * }
     */
    public function registerMenuBox(string $key, array $args = []): void;

    /**
     * @param string $key
     * @param array $args [string $name]
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
        bool   $inFooter = false
    ): void;

    public function enqueueFrontendStyle(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool   $inFooter = false
    ): void;

    public function getProfilePages($key = null): Collection;

    public function registerPermission(string $key, array $args = []): void;

    public function registerResourcePermissions(string $resource, string $name): void;

    /**
     * Register config keys
     *
     * @param array|string $key
     * @param array $args
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
     * Registers an admin page.
     *
     * @param string $key The key that identifies the admin page.
     * @param array $args The arguments to pass with the page registration.
     * This must include a 'title' key as a minimum.
     * @throws Exception when Label Admin Page is required.
     */
    public function registerAdminPage(string $key, array $args): void;

    public function getAPIDocuments(string $key = null): null|Collection|SwaggerDocument;

    public function getDataByKey(string $dataKey, string $key = null): ?Collection;

    /**
     * @param string $key
     * @param array $args
     * @return void
     */
    public function registerEmailHook(string $key, array $args = []): void;

    public function registerSettingPage(string $key, array $args = []): void;

    /**
     * Registers an admin ajax request.
     *
     * @param string $key The key used to identify the AJAX request.
     * @param array $args Optional. An array of arguments for registering the AJAX request. Default empty.
     * - callback: A callable to fire when the request is received.
     * - method: The HTTP method to use for the AJAX request (Default: GET).
     * - key: Used to identify the AJAX request (Default: $key).
     */
    public function registerAdminAjax(string $key, array $args = []): void;

    /**
     * Register navigation menu locations.
     *
     * @param array $locations An associative array of the navigation menu locations to add.
     */
    public function registerNavMenus($locations = []): void;

    public function registerFrontendAjax($key, $args = []): void;
}
