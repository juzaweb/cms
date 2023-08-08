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
use Juzaweb\CMS\Support\Theme\Customize;

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
