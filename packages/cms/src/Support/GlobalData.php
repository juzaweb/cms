<?php

namespace Juzaweb\Support;

use Illuminate\Support\Arr;

class GlobalData
{
    protected $values = [];

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

    public function all()
    {
        return $this->values;
    }
}
