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

use Illuminate\Support\Collection;
use Juzaweb\Support\Theme\Customize;

abstract class CustomizeControl
{
    /**
     * @var Customize
     */
    protected $customize;

    protected $key;

    /**
     * @var Collection
     */
    protected $args;

    public function __construct(Customize $customize, $key, $args = [])
    {
        $this->customize = $customize;
        $this->key = $key;
        $this->args = new Collection($args);
    }

    abstract public function contentTemplate();

    public function getKey()
    {
        return $this->key;
    }

    public function getArgs()
    {
        return $this->args;
    }
}
