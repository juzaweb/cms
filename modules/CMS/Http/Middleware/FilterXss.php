<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Juzaweb\CMS\Support\XssCleaner;

class FilterXss extends TransformsRequest
{
    /**
     * The attributes that should not be filtered.
     *
     * @var array
     */
    protected $except = [];

    /**
     * @var XssCleaner
     */
    protected $cleaner;

    /**
     * FilterXSS constructor.
     *
     * @param XssCleaner $cleaner
     */
    public function __construct(XssCleaner $cleaner)
    {
        $this->except = ['password', 'password_confirmation'];
        $this->cleaner = $cleaner;
    }

    /**
     * Transform the given value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return string|mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }

        if (! is_string($value)) {
            return $value;
        }

        return $this->cleaner->clean($value);
    }
}
