<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Abstracts\PageBlock;

class DefaultPageBlock extends PageBlock
{
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
}
