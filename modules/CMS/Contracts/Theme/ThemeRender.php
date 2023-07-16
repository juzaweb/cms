<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts\Theme;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

interface ThemeRender
{
    public function render(string $view, array $params = []): Factory|View|string|\Inertia\Response;

    public function parseParams(array $params): array;

    public function parseParam($param): mixed;
}
