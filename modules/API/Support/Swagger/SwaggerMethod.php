<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class SwaggerMethod implements Arrayable
{
    protected array $tags = [];
    protected ?string $summary = null;
    protected string $operationId;
    protected Collection $parameters;
    protected Collection $responses;
    protected array $requestBody = [];
    
    public function __construct(protected string $method, protected string $path)
    {
        $this->parameters = new Collection();
        $this->responses = new Collection();
    }
    
    public function operationId(string $operationId): static
    {
        $this->operationId = $operationId;
        
        return $this;
    }
    
    public function getOperationId(): string
    {
        if (isset($this->operationId)) {
            return $this->operationId;
        }
        
        $this->operationId = "api.".str_replace('/', '.', $this->path);
        
        return $this->operationId;
    }
    
    public function summary(string $summary): static
    {
        $this->summary = $summary;
        
        return $this;
    }
    
    public function tags(string|array $tags): static
    {
        if (!is_array($tags)) {
            $tags = [$tags];
        }
        
        $this->tags = $tags;
        
        return $this;
    }
    
    public function parameter(string $name, array $args = [])
    {
        $this->parameters->put(
            $name,
            $args
        );
    }
    
    public function toArray(): array
    {
        return [
            'tags' => $this->tags,
            'summary' => $this->summary,
            'operationId' => $this->getOperationId(),
            'parameters' => $this->parameters->map(
                function ($item, $name) {
                    $item['name'] = $name;
                    return $item;
                }
            )->values(),
            'responses' => $this->responses->map(
                function ($item, $name) {
                    $item['name'] = $name;
                    return $item;
                }
            )->values(),
        ];
    }
}
