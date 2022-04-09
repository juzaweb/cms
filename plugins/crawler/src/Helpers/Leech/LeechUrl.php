<?php

namespace Juzaweb\Crawler\Helpers\Leech;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Juzaweb\CMS\Support\HtmlDom;
use Juzaweb\CMS\Support\HtmlDomNode;
use Psr\Http\Message\ResponseInterface;

class LeechUrl
{
    protected $url;
    protected $content;
    protected $errors = [];
    
    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function init()
    {
        $url = $this->url;
        $params = [];

        if (isset(explode('?', $this->url)[1])) {
            parse_str(explode('?', $this->url)[1], $params);
            $url = explode('?', $this->url)[0];
        }

        try {
            $this->content = $this->get($url, $params);
            return true;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $this->errors[] = $exception->getMessage();
            return false;
        }
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function removeScript()
    {
        $scripts = $this->find('script');
        foreach ($scripts as $script) {
            $this->content = str_replace(
                $script->outertext(),
                '',
                $this->content
            );
        }
    }
    
    public function removeInternalLink()
    {
        $domain = base_domain($this->url);
        $html = str_get_html($this->content);
        $links = $html->find('a');
    
        foreach ($links as $item) {
            if (!is_url($item->href)) {
                if (strpos($item->href, '/url?q=') !== false) {
                    $href = str_replace('/url?q=', '', $item->href);
                    $href = urldecode($href);
                    $href = base64_decode($href);
                    
                    if (is_url($href)) {
                        $text = '<a href="'. $href .'">'. $item->text() .'</a>';
                        $item->outertext = $text;
                    } else {
                        $text = $item->text();
                        $item->outertext = $text;
                    }
                } else {
                    $text = $item->text();
                    $item->outertext = $text;
                }
                
                continue;
            }
            
            if ($domain == base_domain($item->href)) {
                $text = $item->text();
                $item->outertext = $text;
            }
        }
    
        $html->load($html->save());
        $this->content = $html->root->outertext;
    }
    
    public function removeElement($element, $index, $type)
    {
        $html = str_get_html($this->content);
        $content_remove = $html->find($element, $index);
        
        if (!is_null($index)) {
            if ($type == 1) {
                $content_remove->outertext = '';
            }
    
            if ($type == 2) {
                $text = $content_remove->text();
                $content_remove->outertext = $text;
            }
        } else {
            foreach ($content_remove as $item) {
                if ($type == 1) {
                    $item->outertext = '';
                }
        
                if ($type == 2) {
                    $text = $item->text();
                    $item->outertext = $text;
                }
            }
        }
    
        $html->load($html->save());
        $this->content = $html->root->outertext;
    }
    
    /**
     * Content find.
     *
     * @param string $selector
     * @param int $index
     *
     * @return HtmlDom|HtmlDomNode[]|boolean
     */
    public function find($selector, $index = null)
    {
        $html = str_get_html($this->content);
        if ($index === null) {
            return @$html->find($selector);
        }
        
        return @$html->find($selector, $index);
    }
    
    /**
     * Content find plaintext.
     *
     * @param string $selector
     * @param int $index
     *
     * @return string
     */
    public function plaintext($selector, $index = 0)
    {
        $plaintext = $this->find($selector, $index)->plaintext;
        $plaintext = htmlspecialchars_decode($plaintext, ENT_QUOTES);
        return $plaintext;
    }
    
    /**
     * Content find plaintext.
     *
     * @param string $selector
     * @param int $index
     * @return string
     */
    public function innertext($selector, $index = 0)
    {
        return $this->find($selector, $index)->innertext;
    }
    
    public function attribute($selector, $value, $index = 0)
    {
        return $this->find($selector, $index)->{$value};
    }
    
    protected function get($url, $params = [])
    {
        $response = $this->request('GET', $url, ['query' => $params]);
        return $response->getBody()->getContents();
    }
    
    protected function post($url, $params = [], $headers = [])
    {
        $response = $this->request(
            'POST',
            $url,
            ['form_params' => $params, 'headers' => $headers]
        );

        return $response->getBody()->getContents();
    }
    
    /**
     * HTTP get request.
     *
     * @param string $method
     * @param string $url
     * @param array $params
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function request($method, $url, $params)
    {
        $client = new Client();
        $response = $client->request($method, $url, $params);
        return $response;
    }
}
