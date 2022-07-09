<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Arr;
use Juzaweb\CMS\Contracts\GlobalDataContract;

class GlobalData implements GlobalDataContract
{
    protected array $values = [];

    public function set($key, $value)
    {
        Arr::set($this->values, $key, $value);
    }

    public function push($key, $value)
    {
        $data = $this->get($key);
        $data[] = $value;
        $this->set($key, $data);
    }

    public function get($key, $default = [])
    {
        return Arr::get($this->values, $key, $default);
    }

    public function all(): array
    {
        return $this->values;
    }
}
