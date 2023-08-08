<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Support\Collection;

interface JWQueryContract
{
    public function queryRows(string $table, array $args = []): Collection|null;

    public function queryRow(string $table, array $args = []): object|null;

    public function postTaxonomies(array|object $post, string $taxonomy = null, array $params = []): array;

    public function relatedPosts(array|object $post, int $limit = 5, string $taxonomy = null): array;

    public function postTaxonomy(array|object $post, string $taxonomy = null, array $params = []): mixed;
}
