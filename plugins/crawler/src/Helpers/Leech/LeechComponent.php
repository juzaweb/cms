<?php

namespace Juzaweb\Crawler\Helpers\Leech;

use Juzaweb\Crawler\Helpers\Converter\HtmlToBBCode;

class LeechComponent
{
    protected $url;
    protected $components;
    protected $removes;
    
    /**
     * @param string $url
     * @param \Juzaweb\Crawler\Models\Component[] $components
     * @param \Juzaweb\Crawler\Models\CrawRemoveElement[] $removes
     */
    public function __construct($url, $components, $removes = [])
    {
        $this->url = $url;
        $this->components = $components;
        $this->removes = $removes;
    }
    
    public function leech()
    {
        $result = [];
        $content = new LeechUrl($this->url);
        if (!$content->init()) {
            return false;
        }
        
        $content->removeScript();
        $content->removeInternalLink();
        
        foreach ($this->removes as $remove) {
            $content->removeElement($remove->element, $remove->index, $remove->type);
        }
        
        foreach ($this->components as $component) {
            $elementContent = $content->find(
                $component->element,
                $component->index
            );

            if (empty($elementContent)) {
                $result[$component->code] = '';
                continue;
            }

            if (is_null($component->index)) {
                $result[$component->code] = '';
                foreach ($elementContent as $item) {
                    if ($component->attr) {
                        $result[$component->code] .= $item->{$component->attr};
                    } else {
                        $innertext = $item->innertext();
                        if (empty($innertext)) {
                            $result[$component->code] .= '';
                            continue;
                        }

                        $converter = new HtmlToBBCode($innertext);
                        $result[$component->code] .= $converter->toBBCode();
                    }
                }
            } else {
                if ($component->attr) {
                    $result[$component->code] = $elementContent->{$component->attr};
                } else {
                    $innertext = $elementContent->innertext();
                    if (empty($innertext)) {
                        $result[$component->code] .= '';
                    } else {
                        $converter = new HtmlToBBCode($innertext);
                        $result[$component->code] = $converter->toBBCode();
                    }
                }
            }
        }
        
        foreach ($result as $key => $item) {
            $result[$key] = $this->mapParams($item);
        }
        
        return $result;
    }
    
    protected function mapParams($text)
    {
        $params = [
            'url' => $this->url,
        ];
    
        foreach ($params as $key => $param) {
            $text = str_replace('{'. $key .'}', $param, $text);
        }
    
        return $text;
    }
}
