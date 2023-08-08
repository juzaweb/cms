<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @see \Juzaweb\CMS\Support\Html\Field
 */
interface Field
{
    /**
     * Renders the fields using the specified values.
     *
     * @param array $fields The array of fields to render.
     * @param array|Model $values The values to use when rendering the fields. Defaults to an empty array.
     * @param bool $collection Specifies whether the fields represent a collection. Defaults to false.
     * @return View|Factory The rendered view or factory.
     */
    public function render(array $fields, array|Model $values = [], bool $collection = false): View|Factory;

     /**
     * Generates a row for a form.
     *
     * @param array $options The options for the row.
     * @param array|Model $values The values for the row.
     * @return View|Factory The generated row view.
     */
    public function row(array $options, array|Model $values = []): View|Factory;

     /**
     * Creates a column for a form.
     *
     * @param array $options An array of options for the column.
     * @param array|Model $values An array or a model containing the values for the column.
     * @return View|Factory The rendered view or factory object.
     */
    public function col(array $options, array|Model $values = []): View|Factory;

     /**
     * Collects the given array of fields and returns a Collection.
     *
     * @param array $fields The array of fields to collect.
     * @return Collection The resulting Collection object.
     */
    public function collect(array $fields): Collection;

     /**
     * Retrieves the field view or factory based on the given data type.
     *
     * @param array $data The array containing the field data.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|string The field view or factory.
     */
    public function fieldByType(array $data): View|Factory|string;

     /**
     * Generate the function comment for the `text` function.
     *
     * @param string|Model $label The label parameter description.
     * @param string|null $name The name parameter description.
     * @param array|null $options The options parameter description. Defaults to an empty array.
     * @return Factory|View The return value description.
     */
    public function text(string|Model $label, ?string $name, ?array $options = []): Factory|View;

     /**
     * Generates a function comment for the given function body.
     *
     * @param string|Model $label The label for the form input.
     * @param string|null $name The name of the form input.
     * @param array|null $options An array of options for the form input.
     * @return Factory|View The generated view for the form input.
     */
    public function hidden(string|Model $label, ?string $name, ?array $options = []): Factory|View;

     /**
     * Generates a textarea input element for a form.
     *
     * @param string|Model $label The label for the textarea input.
     * @param string|null $name The name attribute for the textarea input.
     * @param array|null $options An array of additional options for the textarea input.
     * @return Factory|View The generated textarea input element.
     */
    public function textarea(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Select a value from the dropdown.
     *
     * @param string|Model $label The label for the select field.
     * @param string|null $name The name attribute for the select field.
     * @param array|null $options The options for the select field.
     * @return Factory|View The rendered view of the select field.
     */
    public function select(string|Model $label, ?string $name, ?array $options = []): Factory|View;

     /**
     * Generates a checkbox input field for a form.
     *
     * @param string|Model $label The label for the checkbox.
     * @param ?string $name The name attribute for the checkbox input field.
     * @param ?array $options An array of options for the checkbox.
     * @return Factory|View The generated checkbox input field.
     */
    public function checkbox(string|Model $label, ?string $name, ?array $options = []): Factory|View;

     /**
     * Generate a slug for a given label and name with optional options.
     *
     * @param string|Model $label The label or model to generate the slug for.
     * @param string|null $name The name of the slug.
     * @param array|null $options Additional options for generating the slug. (Default: [])
     * @return Factory|View The generated slug view.
     */
    public function slug(string|Model $label, ?string $name, ?array $options = []): Factory|View;

     /**
     * Generates the function comment for the given function body.
     *
     * @param string|Model $label The label for the editor.
     * @param string|null $name The name of the editor.
     * @param array|null $options The options for the editor.
     * @return Factory|View The generated view.
     */
    public function editor(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Selects a post using the given label, name, and options and returns a view.
     *
     * @param string|Model $label The label or model used to select the post.
     * @param string|null $name The name of the post.
     * @param array|null $options Additional options for selecting the post.
     * @return View The view representing the selected post.
     */
    public function selectPost(string|Model $label, ?string $name, ?array $options = []): View;

    /**
     * Generates a comment for the given function body.
     *
     * @param string|Model $label The label for the taxonomy.
     * @param string|null $name The name of the taxonomy.
     * @param array|null $options An array of options for the taxonomy.
     * @return Factory|View The rendered view for the taxonomy selection form.
     */
    public function selectTaxonomy(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Select a resource.
     *
     * @param string|Model $label The label of the resource.
     * @param string|null $name The name of the resource.
     * @param array|null $options The options for the resource.
     * @return Factory|View The view for the resource.
     */
    public function selectResource(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Selects a user based on the given label, name, and options.
     *
     * @param string|Model $label The label or model to select the user.
     * @param string|null $name The name of the user.
     * @param array|null $options Additional options for selecting the user.
     * @return Factory|View The rendered view for selecting the user.
     */
    public function selectUser(string|Model $label, ?string $name, ?array $options = []): Factory|View;

     /**
     * Creates and returns an image component for a form.
     *
     * @param string|Model $label The label for the image component.
     * @param string|null $name The name of the image component.
     * @param array|null $options Additional options for the image component.
     * @return Factory|View The created image component.
     */
    public function image(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Generate the function comment for the given function body.
     *
     * @param string|Model $label The label parameter, which can be a string or a Model object.
     * @param string|null $name The name parameter, which is optional and can be null.
     * @param array|null $options The options parameter, which is optional and can be null. It is an array of options.
     * @return Factory|View The return value is either a Factory object or a View object.
     */
    public function images(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Uploads a URL for a given label and name with optional options.
     *
     * @param string|Model $label The label or model to upload the URL for.
     * @param string|null $name The name of the URL.
     * @param array|null $options The optional options for the upload.
     * @return Factory|View The created view for the upload.
     */
    public function uploadUrl(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    /**
     * Generates a view for the security form component.
     *
     * @param string|Model $label The label for the security form component.
     * @param string|null $name The name for the security form component.
     * @param array|null $options The options for the security form component.
     * @return Factory|View The generated view.
     */
    public function security(string|Model $label, ?string $name, ?array $options = []): Factory|View;
}
