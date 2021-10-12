<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Theme\Widgets;

class BannerWidget extends \Juzaweb\Abstracts\Widget
{
    /**
     * Creating widget Backend
     *
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function form($data)
    {
        return view('theme::widgets.banner.form', [
            'data' => $data
        ]);
    }

    /**
     * Creating widget front-end
     *
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function show($data)
    {
        return view('theme::widgets.banner.show', compact(
            'data'
        ));
    }

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
}