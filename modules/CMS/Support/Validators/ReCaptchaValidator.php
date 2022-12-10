<?php

namespace Juzaweb\CMS\Support\Validators;

use GuzzleHttp\Client;

class ReCaptchaValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params' =>
                [
                    'secret' => get_config('google_captcha.secret_key'),
                    'response' => $value,
                ],
            ]
        );

        $body = json_decode((string)$response->getBody());

        return $body->success;
    }
}
