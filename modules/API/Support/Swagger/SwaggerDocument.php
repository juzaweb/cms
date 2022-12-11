<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SwaggerDocument implements Arrayable
{
    protected Collection $paths;
    
    public function __construct(protected string $name, protected array $args = [])
    {
        $this->paths = new Collection();
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function addPath(string $path, callable $callback): static
    {
        $this->paths->put(
            '/api/'.trim($path, '/'),
            $callback(new SwaggerPath($path))
        );
        
        return $this;
    }
    
    public function toArray(): array
    {
        return [
            "openapi" => Arr::get($this->args, 'openapi', '3.0.3'),
            "info" => [
                "title" => Arr::get($this->args, 'title', $this->name),
                "version" => Arr::get($this->args, 'version', 'v1'),
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
                    ]
                ]
            ]
        ];
    }
}
