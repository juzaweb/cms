<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use GuzzleHttp\Exception\ClientException;
use Exception;

class JuzawebApi
{
    protected Curl $curl;
    protected string $apiUrl = 'https://juzaweb.com/api';
    protected ?string $accessToken = null;
    protected ?string $expiresAt = null;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    public function login(string $email, string $password): bool
    {
        $response = $this->callApiGetData(
            'POST',
            $this->apiUrl.'/auth/login',
            [
                'email' => $email,
                'password' => $password,
            ]
        );

        if (empty($response->access_token)) {
            return false;
        }

        $this->accessToken = $response->access_token;
        $this->expiresAt = now()->addSeconds($response->expires_in)
            ->format('Y-m-d H:i:s');
        return true;
    }

    public function get(string $uri, array $params = []): object|array
    {
        return $this->callApi('GET', $uri, $params);
    }

    public function post(string $uri, array $params = []): object|array
    {
        return $this->callApi('POST', $uri, $params);
    }

    public function put(string $uri, array $params = []): object|array
    {
        return $this->callApi('PUT', $uri, $params);
    }

    public function getResponse($uri, $params = []): object|array
    {
        $url = $this->apiUrl.'/'.$uri;

        $response = $this->callApiGetData(
            'GET',
            $this->apiUrl.'/'.$uri,
            $params
        );

        if (empty($response)) {
            throw new Exception("Response is empty url: {$url}");
        }

        return $response;
    }

    protected function callApi(
        string $method,
        string $uri,
        array $params = [],
        array $headers = []
    ): object|array {
        $url = $this->apiUrl.'/'.$uri;

        if ($this->accessToken) {
            $headers['Authorization'] = 'Bearer '.$this->accessToken;
        }

        $response = $this->callApiGetData(
            $method,
            $url,
            $params,
            $headers
        );

        if (empty($response)) {
            throw new Exception("Response is empty url: {$url}");
        }

        return $response;
    }

    protected function callApiGetData(
        string $method,
        string $url,
        array $params = [],
        array $headers = []
    ): object|array {
        try {
            $response = match (strtolower($method)) {
                'post' => $this->curl->post($url, $params, $headers),
                'put' => $this->curl->put($url, $params, $headers),
                default => $this->curl->get($url, $params, $headers),
            };
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\Throwable $e) {
            throw $e;
        }

        $content = $response->getBody()->getContents();

        if (!is_json($content)) {
            throw new Exception("Cannot get json response: {$url}");
        }

        return json_decode($content);
    }
}
