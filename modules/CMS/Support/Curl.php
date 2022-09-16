<?php

namespace Juzaweb\CMS\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Curl
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 60]);
    }

    public function get($url, $params = [], $headers = [])
    {
        if (! empty(explode('?', $url)[1])) {
            $query = explode('?', $url)[1];
            $query = explode('&', $query);

            foreach ($query as $val) {
                $split = explode('=', $val);
                if (! empty($split[1])) {
                    $params[$split[0]] = $split[1];
                }
            }
        }

        return $this->request('GET', $url, $params, $headers);
    }

    public function post($url, $params = [], $headers = [])
    {
        return $this->request('POST', $url, $params, $headers);
    }

    public function put($url, $params = [], $headers = [])
    {
        return $this->request('PUT', $url, $params, $headers);
    }

    public function request($method, $url, $params = [], $headers = [])
    {
        $headers = array_merge(
            [
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) '
                .'Chrome/91.0.4472.124 Safari/537.36',
            ],
            $headers
        );

        $data = [
            'connect_timeout' => 20,
            'headers' => $headers,
        ];

        if ($params) {
            if ($method == 'GET') {
                $data['query'] = $params;
            } else {
                $data['form_params'] = $params;
            }
        }

        $data['curl'] = [
            //CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            //CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) '.
            'Chrome/91.0.4472.124 Safari/537.36',
            //CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        $request = $this->client->request($method, $url, $data);

        return $request;
    }

    public function exists($url)
    {
        try {
            $this->client->head($url);

            return true;
        } catch (ClientException $e) {
            return false;
        }
    }

    public function getClient()
    {
        return $this->client;
    }
}
