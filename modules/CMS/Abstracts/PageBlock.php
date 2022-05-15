<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Abstracts;

use Illuminate\View\View;
use Juzaweb\CMS\Facades\ThemeLoader;
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
        $dataFile = ThemeLoader::getThemePath(
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
