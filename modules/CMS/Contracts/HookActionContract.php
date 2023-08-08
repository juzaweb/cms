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
    /**
     * Add an action to the hook manager.
     *
     * @param string   $tag        The name of the action.
     * @param callable $callback   The callback function to execute when the action is called.
     * @param int      $priority   (Optional) The priority of the action. Default is 20.
     * @param int      $arguments  (Optional) The number of arguments the callback accepts. Default is 1.
     *
     * @return void
     */
    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void;

    /**
     * Add a new filter to the hook system.
     *
     * @param string $tag The tag name of the filter.
     * @param callable $callback The callback function to execute when the filter is applied.
     * @param int $priority The priority of the filter. Default is 20.
     * @param int $arguments The number of arguments accepted by the filter. Default is 1.
     *
     * @return void
     */
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
     * Registers a new taxonomy to be used.
     *
     * @param string $taxonomy The name of the taxonomy.
     * @param array|string $objectType The object type or types that this taxonomy applies to.
     * @param array $args Optional. An array of arguments for registering the taxonomy.
     *        {
     * @type string $label The label for the taxonomy.
     * @type int $priority The priority for displaying the taxonomy in the admin ui.
     * @type bool $hierarchical Whether the taxonomy should be hierarchical.
     * @type string $parent The parent post type or taxonomy.
     * @type string $menu_slug The menu slug for adding the taxonomy to an admin menu.
     * @type int $menu_position The position within the admin menu to add the taxonomy.
     * @type string $model The model class to use for the taxonomy.
     * @type string $menu_icon The icon to use for displaying the taxonomy in the admin ui.
     * @type bool $show_in_menu True if the taxonomy should be added to an admin menu.
     * @type bool $menu_box Whether to show the taxonomy in a meta box on the edit screen.
     * @type bool $rewrite True if the taxonomy should be rewritten (i.e., have pretty permalink support).
     * @type array $supports An array of features to support in the taxonomy.
     *        }
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
     * Adds a new setting form to the global data collection.
     *
     * @param string $key The unique identifier for the setting form being added.
     * @param array $args An array of arguments to configure the setting form.
     * Default values are provided for any argument that is not specified.
     */
    public function addSettingForm(string $key, array $args = []): void;

    /**
     * Add a top-level menu page.
     *
     * This function takes a capability which will be used to determine whether
     *  a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @param string $menuTitle The trans key to be used for the menu.
     * @param string $menuSlug The url name to refer to this menu by. not include admin-cp
     * @param array $args
     * - string $icon Url icon or fa icon fonts
     * - string $parent The parent of menu. Default null
     * - int $position The position in the menu order this item should appear.
     * @return void.
     */
    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void;

    /**
     * Adds a new item to the master admin menu.
     *
     * @param string $menuTitle The title of the menu item to be added.
     * @param string $menuSlug The unique slug identifying the menu item to be added.
     * @param array $args Additional arguments that can be passed to customize the added menu item.
     * @return void
     */
    public function addMasterAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void;

    /**
     * addThumbnailSizes function is used to register new thumbnail sizes to a specific post type.
     *
     * @param string $postType The targeted post type, which the new thumbnail sizes should be added for.
     * @param string|array $size The sizes wanted to be added for each post thumbnail.
     * Can be a single string in the format "WIDTHxHEIGHT", or an array of such strings representing multiple sizes.
     *
     * @return void
     */
    public function addThumbnailSizes(string $postType, string|array $size): void;

    /**
     * Applies all the callbacks attached to the given tag and returns the filtered value.
     *
     * @param string $tag The unique identifier for the filter.
     * @param mixed $value The initial value to be filtered.
     * @param mixed ...$args Optional additional arguments passed to the filter.
     * @return mixed The filtered value.
     */
    public function applyFilters(string $tag, mixed $value, ...$args): mixed;

    /**
     * Retrieve an array of menu boxes from global data, optionally filtered by keys.
     *
     * @param string|array $keys An optional list of keys to filter. If string, filters by that one key.
     * @return array The array of all menu boxes if no keys are specified, or an array of the filtered menu boxes.
     */
    public function getMenuBoxs(string|array $keys = []): array;

    /**
     * Registers a script to be enqueued.
     *
     * @param string $key Unique identifier for the script.
     * @param string $src Path or URL of the script file.
     *  If not a URL, it will be passed through the `asset()` helper function.
     * @param string $ver Version number of the script.
     * @param bool $inFooter Whether the script should be placed in the footer of the HTML document.
     * @return void
     */
    public function enqueueScript(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void;

    /**
     * enqueueStyle() function registers a new stylesheet file for enqueuing in the WordPress environment.
     *
     * @param string $key The ID/key that is unique to the registered stylesheet file.
     * @param string $src The URL or path to the stylesheet file. Default value is an empty string.
     * @param string $ver The version of the stylesheet file. Default value is '1.0'.
     * @param bool $inFooter Determines whether the script tags will be added at the end of the HTML (in footer) or not.
     *
     * @return void
     */
    public function enqueueStyle(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void;

    /**
     * Enqueues a script for the frontend
     *
     * @param string $key The unique key to identify the script
     * @param string $src (Optional) The source URL or asset path of the script file
     * @param string $ver (Optional) The version number of the script
     * @param bool $inFooter (Optional) Load the script in footer
     *
     * @return void
     */
    public function enqueueFrontendScript(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool   $inFooter = false
    ): void;

    /**
     * Enqueues a frontend style on the Website site.
     * @param string $key The key to use as an identifier for this style in the globalData object.
     * @param string $src (Optional) The URL or path of the stylesheet to be enqueued. Defaults to ''.
     * @param string $ver (Optional) The version number of the stylesheet,
     * which is appended to the end of the source URL as a query string. Defaults to '1.0'.
     * @param bool $inFooter (Optional) Whether to enqueue the stylesheet in the footer instead of the head.
     * Defaults to false.
     * @return void
     */
    public function enqueueFrontendStyle(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool   $inFooter = false
    ): void;

    public function getProfilePages($key = null): Collection;

    /**
     * Registers a new permission.
     *
     * @param string $key The unique key of the permission.
     * @param array $args An array of arguments that provide more information about the permission.
     *
     * @return void
     */
    public function registerPermission(string $key, array $args = []): void;

    /**
     * Register a permission group with the provided key and options.
     *
     * @param string $key the unique identifier of the permission group, which should not contain any dots ('.')
     * @param array $args an array of options to customize the permission group; accepted options are:
     *              - name: string, the display name of the permission group
     *              - description: string, a short description of what permissions in this group allow or control
     *              - key: string, a custom unique identifier for this permission group (should be the same as `$key`)
     */
    public function registerPermissionGroup(string $key, array $args = []): void;

    /**
     * Register a set of permissions for a given resource and its various actions.
     *
     * @param string $resource The name of the resource for which permissions are being registered.
     * @param string $name The name of the associated entity
     *
     * @return void
     */
    public function registerResourcePermissions(string $resource, string $name): void;

    /**
     * Register config keys
     *
     * @param array|string $key
     * @param array $args
     */
    public function registerConfig(array|string $key, array $args = []): void;

    /**
     * Returns a collection of permissions, with optional filtering by key.
     *
     * @param string|null $key The key to filter permissions by. Default: null
     *
     * @return Collection A collection of permissions.
     */
    public function getPermissions(?string $key = null): Collection;

    /**
     * Returns a collection of all the configuration values or the value of given $key.
     *
     * @param string|null $key The key whose value is required. By default, null.
     *
     * @return Collection Returns a collection of all configuration values if $key is not specified or returns
     *                   the value of the given $key if it exists, otherwise an empty Collection is returned.
     */
    public function getConfigs(string|null $key = null): Collection;

    /**
     * Get a collection of taxonomies for the given post type, sorted by menu_position.
     *
     * @param string|array|null $postType The slug or array containing the key of
     * the post type whose taxonomies to retrieve.
     * @return Collection A collection of taxonomies.
     */
    public function getTaxonomies(string|array|null $postType = null): Collection;

    /**
     * Add meta data to a specific post type
     *
     * @param string $postType The post type key to add meta to
     * @param array $metas The additional meta data to include
     * @return void
     */
    public function addMetaPostTypes(string $postType, array $metas): void;

    /**
     * Registers email templates in the system.
     *
     * @param string $key The unique identifier of the email template.
     * @param array $args An array containing email template data. Optional parameters include:
     * code: The code associated with the email template.
     * subject: The subject line of the email template.
     * body: The contents of the email template.
     * params: Variables that can be used in the email body.
     * email_hook: The email hook that triggers this template.
     * @return void
     */
    public function registerEmailTemplate(string $key, array $args = []): void;

    /**
     * Retrieve the thumbnail sizes registered for a specific post type, or all post types.
     *
     * @param string|null $postType Optional. The post type to retrieve thumbnail sizes for.
     * If null, retrieves all thumbnail sizes for all post types.
     * @return Collection Returns a Collection object containing the registered thumbnail sizes.
     */
    public function getThumbnailSizes(?string $postType = null): Collection;

    /**
     * Retrieve all post types or a specific post type by key.
     *
     * @param string|null $postType Key of the post type to retrieve, or null to retrieve all post types.
     *
     * @return Collection A collection of post types if $postType is null,
     * or the data for the specified post type.
     */
    public function getPostTypes(string $postType = null): Collection;

    /**
     * Get email templates from global data by key or all templates if key is null.
     *
     * @param string|null $key The key of the email template to retrieve.
     *
     * @return ?Collection A collection of email templates if key is provided,
     * otherwise a collection of all email templates.
     * Returns NULL if no email templates are found.
     */
    public function getEmailTemplates(?string $key = null): ?Collection;

    /**
     * Registers an admin page.
     *
     * @param string $key The key that identifies the admin page.
     * @param array $args The arguments to pass with the page registration.
     * This must include a 'title' key as a minimum.
     * @throws Exception when Label Admin Page is required.
     */
    public function registerAdminPage(string $key, array $args): void;

    public function getAPIDocuments(?string $key = null): null|Collection|SwaggerDocument;

    public function getDataByKey(string $dataKey, string $key = null): ?Collection;

    /**
     * Registers an email hook.
     *
     * @param string $key The unique identifier for the email hook.
     * @param array $args {
     *     Optional. An array of arguments for the email hook.
     *
     * @type string $label A label for the email hook.
     * @type array $params Extra parameters that can be passed to the email hook.
     * }
     */
    public function registerEmailHook(string $key, array $args = []): void;

    /**
     * Register a sidebar.
     *
     * @param string $key The unique identifier of the sidebar.
     * @param array $args An array of arguments to define the sidebar's properties:
     *   - label (string): The label for the sidebar displayed in the WordPress admin.
     *   - key (string): Required. The unique identifier for the sidebar.
     *   - description (string): A brief description of the sidebar.
     *   - before_widget (string): HTML markup to prepend to each widget in the sidebar.
     *   - after_widget (string): HTML markup to append to each widget in the sidebar.
     *
     * @return void
     */
    public function registerSidebar(string $key, array $args = []): void;

    /**
     * Registers a new widget.
     *
     * @param string $key The unique key for this widget.
     * @param array $args Widget settings.
     * @type string $label The name of the widget as shown in the admin panel.
     * @type string $description A brief description of what the widget is used for.
     * @type string $widget The PHP class responsible for rendering the widget.
     * @return void
     */
    public function registerWidget(string $key, array $args = []): void;

    /**
     * Register a new page block.
     *
     * @param string $key The unique identifier for the block.
     * @param array $args An associative array of arguments to configure and describe the block.
     * @return void
     */
    public function registerPageBlock(string $key, array $args = []): void;

    /**
     * Registers a new setting page to the theme or plugin.
     *
     * @param string $key The unique identifier of the setting page.
     * @param array $args Optional. An array of arguments to define the settings page. Default is an empty array.
     * @return void
     */
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
    public function registerNavMenus(array $locations = []): void;

    /**
     * Register a new Frontend Ajax.
     *
     * @param string $key Unique key to register.
     * @param array $args Optional arguments for registration.
     * @option bool    'auth'   Whether the callback must be authenticated. Default is false.
     * @required string 'callback' The callback function invoked when request matched the route.
     * @option string 'key'    Alternative key name (replacing the key parameter above).
     * @option string 'method'    Method allowed (default: get).
     *
     * @throws Exception Throws exception if callback option is not provided.
     */
    public function registerFrontendAjax(string $key, array $args = []): void;

    /**
     * Registers Theme Templates.
     *
     * @param string $key Unique identifier for the template in the database.
     * @param array $args Information about template e.g. file name, view type etc.
     *
     * @return void
     */
    public function registerThemeTemplate(string $key, array $args = []): void;

    /**
     * Registers a new setting for the active theme with given parameters.
     *
     * @param string $name Unique identifier of the setting
     * @param string $label Label to be shown for the setting
     * @param array $args An array containing other necessary arguments.
     *  key (string): A unique identifier for the theme template being registered.
     * Default value is set to the provided $key parameter.
     * name (string): A human-readable name or title for the template. Default value is set to an empty string.
     * view (string): The file path (relative or absolute) of the template file.
     * Default value is set to an empty string.
     * @return void
     */
    public function registerThemeSetting(string $name, string $label, array $args = []): void;

    /**
     * Get list of permalinks or a specific permalink by key.
     *
     * @param string|null $key The permalink key to get (optional).
     *
     * @return array|Collection|null If a key is provided, returns specific permalink collection.
     * Returns array of all permalinks otherwise.
     */
    public function getPermalinks(?string $key = null): array|Collection|null;

    /**
     * Get the collection of email hooks or a specific email hook.
     *
     * @param string|null $key Optional. The unique key of an email hook. Default null.
     *
     * @return Collection|null Returns a collection of all email hooks or a specific email hook.
     */
    public function getEmailHooks(?string $key = null): ?Collection;

    /**
     * Get all registered widgets or retrieve specific widget by key.
     *
     * @param string|null $key Key of the specific widget to retrieve
     * @return Collection|null The collection of all registered widgets or collection with the widget's data
     * if a $key parameter is provided
     */
    public function getWidgets(?string $key = null): ?Collection;

    /**
     * Get the page blocks for the given key.
     *
     * @param string|null $key The key to use as an index in the page_blocks global data array.
     * @return Collection|null Returns an instance of Collection containing the page blocks.
     */
    public function getPageBlocks(?string $key = null): ?Collection;

    /**
     * Get Frontend Ajaxs collection or a specific key's data.
     *
     * @param  string|null  $key
     * @return Collection|bool
     */
    public function getFrontendAjaxs(string $key = null): Collection|bool;

    /**
     * Get theme templates.
     *
     * @param  string|null  $key
     * @return Collection|null
     */
    public function getThemeTemplates(string $key = null): ?Collection;
}
