<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Abstracts;

use Illuminate\Support\Arr;
use Illuminate\View\View;
use Juzaweb\Facades\Theme;
use TwigBridge\Facade\Twig;

abstract class Widget
{
    protected $theme;
    protected $widgetKey;
    protected $data;

    public function __construct(
        $theme,
        $widgetKey,
        $data
    ) {
        $this->theme = $theme;
        $this->widgetKey = $widgetKey;
        $this->data = $data;
    }

    /**
     * Creating widget Backend
     *
     * @param array $data
     * @return View
     */
    abstract public function form($data);

    /**
     * Creating widget front-end
     *
     * @param array $data
     * @return View
     */
    abstract public function show($data);

    /**
     * Updating data block
     *
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        return $data;
    }

    protected function view($view, $params = [])
    {
        return Twig::render($view, $params);
    }

    public function getJsonForm()
    {
        if ($form = Arr::get($this->data, 'form')) {
            $resourcePath = base_path('packages/backend/src/resources');
            $file = str_replace(['cms::', '.'], ["{$resourcePath}/", '/'], $form);
            $dataFile = $file . '.json';
        } else {
            $dataFile = Theme::getThemePath(
                $this->theme,
                "data/widgets/{$this->widgetKey}.json"
            );
        }

        if (!file_exists($dataFile)) {
            return [];
        }

        $data = collect(json_decode(file_get_contents($dataFile), true));
        return $data;
    }
}
