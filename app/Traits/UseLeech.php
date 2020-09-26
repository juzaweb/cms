<?php

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

trait UseLeech
{
    protected function getContent($url, $params = []) {
        $response = $this->_get($url, ['query' => $params]);
        return $response->getBody()->getContents();
    }
    
    protected function post($url, $params = [], $headers = []) {
        $response = $this->_post($url, ['form_params' => $params, 'headers' => $headers]);
        
        return $response->getBody()->getContents();
    }
    
    protected function getMovieName($name) {
        $name = preg_replace('/\(\d{4}\)/', ' ', $name);
        return trim($name);
    }
    
    /**
     * Content find.
     *
     *
     * @param string $content
     * @param string $selector
     * @param int $index
     *
     * @return \simple_html_dom_node|\simple_html_dom_node[]
     */
    protected function find($content, $selector, $index = null) {
        $html = str_get_html($content);
        if ($index === null) {
            return @$html->find($selector);
        }
    
        return @$html->find($selector, $index);
    }
    
    /**
     * Content find plaintext.
     *
     *
     * @param string $content
     * @param string $selector
     * @param int $index
     *
     * @return string
     */
    protected function plaintext($content, $selector, $index = 0) {
        $plaintext = $this->find($content, $selector, $index)->plaintext;
        $plaintext = htmlspecialchars_decode($plaintext, ENT_QUOTES);
        return $plaintext;
    }
    
    /**
     * Content find plaintext.
     *
     *
     * @param string $content
     * @param string $selector
     * @param int $index
     *
     * @return string
     */
    protected function innertext($content, $selector, $index = 0) {
        return $this->find($content, $selector, $index)->innertext;
    }
    
    /**
     * HTTP get request.
     *
     *
     * @param string              $url
     * @param array $params
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function _get($url, $params) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url, $params);
        return $response;
    }
    
    /**
     * HTTP post request.
     *
     *
     * @param string              $url
     * @param array $params
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function _post($url, $params) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, $params);
        return $response;
    }
}