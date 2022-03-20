<?php

namespace Juzaweb\Crawler\Helpers\Leech;

class LeechListItems
{
    protected $url;
    protected $element;
    protected $attr;
    protected $remove_query_string = 1;
    
    public function __construct($url, $element, $attr = 'href')
    {
        $this->url = $url;
        $this->element = $element;
        $this->attr = $attr;
    }
    
    public function removeQueryString($val)
    {
        $this->remove_query_string = $val;
    }
    
    public function getItems()
    {
        $content = new LeechUrl($this->url);
        if (!$content->init()) {
            return [];
        }
        
        $item_urls = [];
        $urls = $content->find($this->element);
        
        if (empty($urls)) {
            return [];
        }
        
        foreach ($urls as $url) {
            if ($this->remove_query_string) {
                $ourl = remove_query_url($url->getAttribute($this->attr));
                $item_urls[] = $this->getUrl($ourl);
            } else {
                $ourl = $url->getAttribute($this->attr);
                $item_urls[] = $this->getUrl($ourl);
            }
        }
    
        if (empty($item_urls)) {
            return [];
        }
    
        return $item_urls;
    }
    
    protected function getUrl($url)
    {
        if (is_url($url)) {
            return $url;
        }
        
        return $this->getBaseUrl($this->url) . $url;
    }
    
    protected function getBaseUrl($url)
    {
        $split = explode('/', $url);
        return $split[0] . '//' . $split[2];
    }
}
