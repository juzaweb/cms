<?php

namespace Juzaweb\Support\Validators;

use GuzzleHttp\Client;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params' =>
                [
                    'secret' => get_config('google_recaptcha_secret'),
                    'response' => $value,
                ],
            ]
        );

        $body = json_decode((string)$response->getBody());

        return $body->success;
    }
}
