<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class SwaggerVersion implements Arrayable
{
    protected Collection $paths;
    
    public function __construct(protected string $version)
    {
        $this->paths = new Collection();
        $this->version = $version;
    }
    
    public function addPath(string $path, callable $callback): static
    {
        $this->paths->put(
            '/'.trim($path, '/'),
            $callback(new SwaggerPath($path))
        );
        
        return $this;
    }
    
    public function toArray()
    {
        return [
            "openapi" => "3.0.0",
            "info" => [
                "title" => "",
                "version" => "v1",
            ],
            'paths' => $this->paths
                ->map(
                    function ($item) {
                        return $item;
                    }
                )
                ->toArray(),
        ];
    }
}
