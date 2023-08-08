<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use GuzzleHttp\Exception\ClientException;
use Exception;
use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\ConfigContract;
use Juzaweb\CMS\Contracts\JuzawebApiContract;

class JuzawebApi implements JuzawebApiContract
{
    protected Curl $curl;

    protected ConfigContract $config;

    protected string $apiUrl = 'https://juzaweb.com/api';

    protected ?string $accessToken = null;

    protected ?string $expiresAt = null;

    public function __construct(ConfigContract $config)
    {
        $this->curl = app(Curl::class);

        $this->config = $config;
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

        if (empty($response->data->access_token)) {
            return false;
        }

        $this->setAccessToken($response->data->access_token);

        $this->expiresAt = date('Y-m-d H:i:s', strtotime($response->data->expires_at));
        return true;
    }

    public function checkActivationCode(string $module, string $name, string $code): object
    {
        return $this->post(
            "modules/{$module}/activation-code",
            [
                'name' => $name,
                'code' => $code,
                'domain' => request()->getHttpHost()
            ]
        );
    }

    public function getActivationCodes(string $module, string $name): object
    {
        return $this->get(
            "modules/activation-codes",
            [
                'name' => $name,
                'type' => Str::plural($module),
                'domain' => request()->getHttpHost()
            ]
        );
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->config->setConfig('juzaweb_access_token', $accessToken);

        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): ?string
    {
        if (isset($this->accessToken)) {
            return $this->accessToken;
        }

        return $this->config->getConfig('juzaweb_access_token');
    }

    public function get(string $uri, array $params = [], array $headers = []): object|array
    {
        return $this->callApi('GET', $uri, $params, $headers);
    }

    public function post(string $uri, array $params = [], array $headers = []): object|array
    {
        return $this->callApi('POST', $uri, $params, $headers);
    }

    public function put(string $uri, array $params = [], array $headers = []): object|array
    {
        return $this->callApi('PUT', $uri, $params, $headers);
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

        if ($accessToken = $this->getAccessToken()) {
            $headers['Authorization'] = "Bearer {$accessToken}";
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
