<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\AdsManagement\Entities;

class Position
{
    public string $name;

    public string $type;

    public function __construct(public string $key, public array $options = [])
    {
        $this->name = $options['name'] ?? title_from_key($key);
        $this->type = $options['type'];
    }
}
