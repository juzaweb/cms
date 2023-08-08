<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Support\Documentation;

use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\API\Support\Swagger\SwaggerMethod;
use Juzaweb\API\Support\Swagger\SwaggerPath;

class AuthSwaggerDocumentation implements APISwaggerDocumentation
{
    public function handle(SwaggerDocument $document): SwaggerDocument
    {
        $document->path(
            'auth/login',
            function (SwaggerPath $path) {
                $path->method(
                    'post',
                    function (SwaggerMethod $method) {
                        $method->operationId("auth.login");
                        $method->summary("Login");
                        $method->tags(['Auth']);
                        $method->setRequestBody(
                            [
                                'required' => true,
                                'content' => [
                                    'multipart/form-data' => [
                                        'schema' => [
                                            'required' => [
                                                'email',
                                                'password',
                                            ],
                                            'properties' => [
                                                'email' => [
                                                    'description' => 'Email',
                                                    'type' => 'string',
                                                ],
                                                'password' => [
                                                    'description' => 'password',
                                                    'type' => 'string',
                                                ],
                                                'g-recaptcha-response' => [
                                                    'description' => '(Optional) Token of Google Recaptcha V2',
                                                    'type' => 'string',
                                                ],
                                            ],
                                            'type' => 'object',
                                        ],
                                    ],
                                ],
                            ]
                        );
                        return $method;
                    }
                );

                return $path;
            }
        );

        $document->path(
            'auth/register',
            function (SwaggerPath $path) {
                $path->method(
                    'post',
                    function (SwaggerMethod $method) {
                        $method->operationId("auth.register");
                        $method->summary("Register");
                        $method->tags(['Auth']);
                        $method->setRequestBody(
                            [
                                'required' => true,
                                'content' => [
                                    'multipart/form-data' => [
                                        'schema' => [
                                            'required' => [
                                                'name',
                                                'email',
                                                'password',
                                                'password_confirmation',
                                            ],
                                            'properties' => [
                                                'name' => [
                                                    'description' => 'name',
                                                    'type' => 'string',
                                                    'example' => 'string',
                                                ],
                                                'email' => [
                                                    'description' => 'email',
                                                    'type' => 'string',
                                                    'example' => 'example@gmail.com',
                                                ],
                                                'password' => [
                                                    'description' => 'password',
                                                    'type' => 'string',
                                                    'example' => 'password',
                                                ],
                                                'password_confirmation' => [
                                                    'description' => 'password_confirmation',
                                                    'type' => 'string',
                                                    'example' => 'password',
                                                ],
                                                'g-recaptcha-response' => [
                                                    'description' => '(Optional) Token of Google Recaptcha V2',
                                                    'type' => 'string',
                                                ],
                                            ],
                                            'type' => 'object',
                                        ],
                                    ],
                                ],
                            ]
                        );
                        return $method;
                    }
                );

                return $path;
            }
        );

        return $document;
    }
}
