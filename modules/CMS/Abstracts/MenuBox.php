<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Abstracts;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Juzaweb\Backend\Models\MenuItem;

abstract class MenuBox
{
    /**
     * Get data from request
     *
     * @param array $data
     * @return array
     *
     * Return multi data to map menu_items table
     */
    abstract public function mapData($data);

    /**
     * Get data for item menu
     *
     * @param array $item //
     *
     *
     * @return array
     * Return data to map menu_items table
     */
    abstract public function getData($item);

    /**
     * Get view for add item
     *
     * @return View
     */
    abstract public function addView();

    /**
     * Get view for edit item
     *
     * @param MenuItem $item
     * @return View
     */
    abstract public function editView($item);

    /**
     * Get link for item
     *
     * @param Collection $menuItems
     * @return array // array url
     */
    abstract public function getLinks($menuItems);
}
