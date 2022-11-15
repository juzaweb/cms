<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

interface Field
{
    public function text(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function hidden(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function textarea(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function select(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function checkbox(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function slug(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function editor(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function selectPost(string|Model $label, ?string $name, ?array $options = []): View;

    public function selectTaxonomy(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function selectResource(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function selectUser(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function image(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function images(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function uploadUrl(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function security(string|Model $label, ?string $name, ?array $options = []): Factory|View;

    public function fieldByType(array $data): View|Factory|string;
}
