<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Abstracts;

use Illuminate\View\View;
use Juzaweb\Facades\Theme;
use TwigBridge\Facade\Twig;

abstract class PageBlock
{
    protected $data;
    protected $theme;

    public function __construct(
        $data,
        $theme
    ) {
        $this->data = $data;
        $this->theme = $theme;
    }

    /**
     * Creating widget front-end
     *
     * @param array $data
     * @return View
     */
    abstract public function show($data);

    public function getData()
    {
        $dataFile = Theme::getThemePath(
            $this->theme,
            "data/blocks/{$this->data['key']}.json"
        );

        if (!file_exists($dataFile)) {
            return [];
        }

        $data = collect(json_decode(file_get_contents($dataFile), true));
        return $data;
    }

    protected function view($view, $params = [])
    {
        return Twig::render($view, $params);
    }
}
