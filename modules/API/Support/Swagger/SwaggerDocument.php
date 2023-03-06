<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\API\Support\Documentation\APISwaggerDocumentation;

class SwaggerDocument implements Arrayable
{
    protected string $prefix;
    protected string $title;
    protected string $openapi = '3.0.3';
    protected string $version = 'v1';
    protected Collection $paths;

    /**
     * Create a new instance of the current class.
     *
     * @param string $name The name to assign to the instance.
     *
     * @return static The newly created instance.
     */
    public static function make(string $name): static
    {
        return new static($name);
    }

    public function __construct(protected string $name)
    {
        $this->paths = new Collection();
        $this->title = Str::ucfirst($this->name);
    }

    /**
     * Set the title of the Swagger documentation.
     *
     * @param  string  $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the prefix for the Swagger API paths.
     *
     * @param  string  $prefix
     * @return $this
     */
    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the current prefix for the Swagger API paths.
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Get the name of this instance of the Swagger documentation.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Add a new path to the Swagger documentation.
     *
     * @param  string    $path
     * @param  callable  $callback
     * @return $this
     */
    public function path(string $path, callable $callback): static
    {
        $base = isset($this->prefix) ? "/api/{$this->getPrefix()}/" : '/api/';

        $this->paths->put(
            $base . trim($path, '/'),
            $callback(new SwaggerPath($path))
        );

        return $this;
    }

    public function append(string|APISwaggerDocumentation $document): static
    {
        if (is_string($document)) {
            $document = app($document);
        }

        $document->handle($this);

        return $this;
    }

    public function toArray(): array
    {
        return [
            "openapi" => $this->openapi,
            "info" => [
                "title" => $this->title,
                "version" => $this->version,
            ],
            'paths' => $this->paths
                ->map(
                    function ($item) {
                        return $item;
                    }
                )
                ->toArray(),
            'components' => [
                "responses" => [
                    "success_detail" => [
                        "description" => "Get Data Success",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "data" => [
                                            "type" => "object"
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "success_list" => [
                        "description" => "Get List Success",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "data" => [
                                            "type" => "array",
                                            "items" => [
                                                "type" => "object"
                                            ]
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "success_paging" => [
                        "description" => "Get Paging Success",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "data" => [
                                            "type" => "array",
                                            "items" => [
                                                "type" => "object"
                                            ]
                                        ],
                                        "links" => [
                                            "properties" => [
                                                "self" => [
                                                    "type" => "string"
                                                ],
                                                "first" => [
                                                    "type" => "string"
                                                ],
                                                "prev" => [
                                                    "type" => "string"
                                                ],
                                                "next" => [
                                                    "type" => "string"
                                                ],
                                                "last" => [
                                                    "type" => "string"
                                                ]
                                            ],
                                            "type" => "object"
                                        ],
                                        "meta" => [
                                            "properties" => [
                                                "totalPages" => [
                                                    "type" => "integer"
                                                ],
                                                "limit" => [
                                                    "type" => "integer"
                                                ],
                                                "total" => [
                                                    "type" => "integer"
                                                ],
                                                "page" => [
                                                    "type" => "integer"
                                                ]
                                            ],
                                            "type" => "object"
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "error_401" => [
                        "description" => "Token Error",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "errors" => [
                                            "type" => "array",
                                            "items" => [
                                                "properties" => [
                                                    "code" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ],
                                                    "title" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ]
                                                ],
                                                "type" => "object"
                                            ]
                                        ],
                                        "message" => [
                                            "type" => "string",
                                            "example" => ""
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "error_403" => [
                        "description" => "Permission denied",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "errors" => [
                                            "type" => "array",
                                            "items" => [
                                                "properties" => [
                                                    "code" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ],
                                                    "title" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ]
                                                ],
                                                "type" => "object"
                                            ]
                                        ],
                                        "message" => [
                                            "type" => "string",
                                            "example" => ""
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "error_404" => [
                        "description" => "Page not found",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "errors" => [
                                            "type" => "array",
                                            "items" => [
                                                "properties" => [
                                                    "code" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ],
                                                    "title" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ]
                                                ],
                                                "type" => "object"
                                            ]
                                        ],
                                        "message" => [
                                            "type" => "string",
                                            "example" => ""
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "error_422" => [
                        "description" => "Validate Error",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "errors" => [
                                            "type" => "array",
                                            "items" => [
                                                "properties" => [
                                                    "field" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ],
                                                    "message" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ]
                                                ],
                                                "type" => "object"
                                            ]
                                        ],
                                        "message" => [
                                            "type" => "string",
                                            "example" => ""
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ],
                    "error_500" => [
                        "description" => "Server Error",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "properties" => [
                                        "errors" => [
                                            "type" => "array",
                                            "items" => [
                                                "properties" => [
                                                    "code" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ],
                                                    "title" => [
                                                        "type" => "string",
                                                        "example" => ""
                                                    ]
                                                ],
                                                "type" => "object"
                                            ]
                                        ],
                                        "message" => [
                                            "type" => "string",
                                            "example" => ""
                                        ]
                                    ],
                                    "type" => "object"
                                ]
                            ]
                        ]
                    ]
                ],
                "parameters" => [
                    "path_id" => [
                        "name" => "id",
                        "in" => "path",
                        "required" => true,
                        "schema" => [
                            "type" => "string"
                        ]
                    ],
                    "path_slug" => [
                        "name" => "slug",
                        "in" => "path",
                        "required" => true,
                        "schema" => [
                            "type" => "string"
                        ]
                    ],
                    "query_limit" => [
                        "name" => "limit",
                        "in" => "query",
                        "schema" => [
                            "type" => "integer"
                        ]
                    ],
                    "query_page" => [
                        "name" => "page",
                        "in" => "query",
                        "schema" => [
                            "type" => "integer"
                        ]
                    ],
                    "query_keyword" => [
                        "name" => "q",
                        "in" => "query",
                        "schema" => [
                            "type" => "string"
                        ]
                    ],
                    "body_recapcha" => [
                        "name" => "g-recaptcha-response",
                        'description' => '(Optional) Token of Google Recaptcha V2',
                        'type' => 'string',
                    ]
                ]
            ]
        ];
    }
}
