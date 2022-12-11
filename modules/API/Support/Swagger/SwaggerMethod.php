<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;

class SwaggerMethod implements Arrayable
{
    protected array $tags = [];
    protected ?string $summary = null;
    protected string $operationId;
    protected array $parameters = [];
    protected array $responses = [];
    protected array $requestBody = [];
    
    public function __construct(protected string $method, protected string $path)
    {
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
    
    public function toArray(): array
    {
        return [
            'tags' => $this->tags,
            'summary' => $this->summary,
            'operationId' => $this->getOperationId(),
            'parameters' => $this->parameters,
            'responses' => $this->responses,
        ];
    }
}
