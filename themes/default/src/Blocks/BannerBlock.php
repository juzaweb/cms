<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Theme\Blocks;

use Illuminate\View\View;
use Juzaweb\Abstracts\PageBlock;

class BannerBlock extends PageBlock
{

    /**
     * Creating widget Backend
     *
     * @return View
     */
    public function form()
    {
        return view('theme::blocks.banner.form');
    }

    /**
     * Creating widget front-end
     *
     * @param array $data
     * @return View
     */
    public function show($data)
    {
        // TODO: Implement show() method.
    }

    /**
     * Updating data block
     *
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        // TODO: Implement update() method.
    }
}
