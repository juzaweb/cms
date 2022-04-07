<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Abstracts\Widget;

class DefaultWidget extends Widget
{
    /**
     * Creating widget Backend
     *
     * @param array $inputData
     * @return \Illuminate\View\View
     */
    public function form($inputData)
    {
        $data = $this->getJsonForm();

        return view(
            'cms::backend.widget.components.widget_form',
            [
                'data' => $data,
                'key' => $inputData['key'],
                'value' => $inputData,
            ]
        );
    }

    /**
     * Creating widget front-end
     *
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function show($data)
    {
        return $this->view(
            $this->data['view'],
            compact(
                'data'
            )
        );
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
