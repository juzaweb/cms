<?php

namespace Juzaweb\Crawler\Helpers\Translate;

class TranslateComponent
{
    protected $components;
    protected $preview;
    
    public function __construct($components, $preview = false) {
        $data_components = [];
        foreach ($components as $com) {
            $data_components[$com->code] = $com;
        }
        
        $this->components = $data_components;
        $this->preview = $preview;
    }
    
    public function translate($components_trans, $source, $target) {
        foreach ($components_trans as $key => $component) {
            if (isset($this->components[$key])) {
                if ($this->components[$key]->trans == 1) {
                    $translate = new TranslateText($source, $target, $component, $this->preview);
                    $translate_text = $translate->translateBBCode();
                    if ($translate_text === false) {
                        return false;
                    }
                    
                    $components_trans[$key] = $translate_text;
                }
            }
        }
        
        return $components_trans;
    }
}