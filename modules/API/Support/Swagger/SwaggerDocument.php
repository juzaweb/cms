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
            '/'.trim($path, '/'),
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
        ];
    }
}
