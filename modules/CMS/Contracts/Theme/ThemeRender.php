<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts\Theme;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * @see \Juzaweb\CMS\Support\Theme\ThemeRender
 */
interface ThemeRender
{
    /**
     * Renders the view based on the theme's template.
     *
     * @param string $view The name of the view to render.
     * @param array $params The parameters to pass to the view.
     * @return Factory|View|string|\Inertia\Response The rendered view.
     */
    public function render(string $view, array $params = []): Factory|View|string|\Inertia\Response;

    /**
     * Parses the parameters based on the theme's template.
     *
     * @param array $params The parameters to parse.
     * @return array The parsed parameters.
     */
    public function parseParams(array $params): array;

    /**
     * Parses a single parameter based on the theme's template.
     *
     * @param mixed $param The parameter to parse.
     * @return mixed The parsed parameter.
     */
    public function parseParam($param): mixed;
}
