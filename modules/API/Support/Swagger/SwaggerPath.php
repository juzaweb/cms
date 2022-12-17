<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class SwaggerPath implements Arrayable
{
    protected Collection $methods;
    
    public function __construct(protected string $path)
    {
        $this->methods = new Collection();
    }
    
    public function method(string $method, callable $callback): static
    {
        $this->methods->put(
            $method,
            $callback($this->createSwaggerMethod($method))
        );
        
        return $this;
    }
    
    public function getMethod(string $method): ?SwaggerMethod
    {
        return $this->methods->get($method);
    }
    
    public function toArray(): array
    {
        return $this->methods->toArray();
    }
    
    protected function createSwaggerMethod(string $method): SwaggerMethod
    {
        return new SwaggerMethod($method, $this->path);
    }
}
