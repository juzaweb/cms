<?php

namespace Juzaweb\Crawler\Helpers\Converter;

abstract class Converter {
    
    protected $text;
    protected $dom;
    
    public function __construct($text) {
        $this->text = $text;
    }
}