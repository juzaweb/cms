<?php

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Juzaweb\Extension\Laravel;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Access Laravels auth class in your Twig templates.
 */
class Custom extends AbstractExtension
{
    public function __construct()
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'App_Extension_Laravel_Custom';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('config', 'get_config'),
            new TwigFunction('get_template_part', 'get_template_part'),
            new TwigFunction('text_field', 'Field::text'),
            new TwigFunction('textarea_field', 'Field::textarea'),
            new TwigFunction('select_field', 'Field::select'),
            new TwigFunction('select_taxonomy_field', 'Field::selectTaxonomy'),
            new TwigFunction('select_resource_field', 'Field::selectResource'),
            new TwigFunction('jw_nav_menu', 'jw_nav_menu', ['is_safe' => ['html']]),
            new TwigFunction('request_is', [app('request'), 'is']),
            new TwigFunction('json_decode', 'json_decode'),
            new TwigFunction('json_encode', 'json_encode'),
            //new TwigFunction('auth', [$this->auth, 'check']),
            //new TwigFunction('guest', [$this->auth, 'guest']),
            //new TwigFunction('auth_user', [$this->auth, 'user']),
            //new TwigFunction('auth_guard', [$this->auth, 'guard']),
        ];
    }
}
