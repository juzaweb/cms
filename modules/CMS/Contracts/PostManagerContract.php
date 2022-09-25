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

use Juzaweb\Backend\Models\Post;

interface PostManagerContract
{
    public function create(array $data, array $options = []): Post;

    public function update(array $data, int $id, array $options = []): Post;
}
