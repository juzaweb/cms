<?php

namespace Juzaweb\CMS\Support\Config;

class GenerateConfigReader
{
    public static function read(string $value): GeneratorPath
    {
        return new GeneratorPath(config("plugin.paths.generator.$value"));
    }
}
