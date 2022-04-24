<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class EnqueueStyleAction extends Action
{
    public function handle()
    {
        $this->addAction(self::BACKEND_HEADER_ACTION, [$this, 'enqueueStylesHeader']);
        $this->addAction(self::BACKEND_FOOTER_ACTION, [$this, 'enqueueStylesFooter']);
    }

    public function enqueueStylesHeader()
    {
        $scripts = get_enqueue_scripts(false);
        $styles = get_enqueue_styles(false);

        foreach ($styles as $style) {
            $href = e($style->get('src')) .'?v='. e($style->get('ver'));
            echo '<link rel="stylesheet" type="text/css" href="'. $href .'">';
        }

        foreach ($scripts as $script) {
            $href = e($script->get('src')) .'?v='. e($script->get('ver'));
            echo '<script src="'. $href .'"></script>';
        }
    }

    public function enqueueStylesFooter()
    {
        $scripts = get_enqueue_scripts(true);
        $styles = get_enqueue_styles(true);

        foreach ($styles as $style) {
            $href = e($style->get('src')) .'?v='. e($style->get('ver'));
            echo '<link rel="stylesheet" type="text/css" href="'. $href .'">';
        }

        foreach ($scripts as $script) {
            $href = e($script->get('src')) .'?v='. e($script->get('ver'));
            echo '<script src="'. $href .'"></script>';
        }
    }
}
