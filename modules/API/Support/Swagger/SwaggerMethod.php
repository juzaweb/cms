<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class SwaggerMethod implements Arrayable
{
    protected array $tags = [];
    protected string $summary;
    protected string $operationId;
    protected Collection $parameters;
    protected Collection $responses;
    protected Collection $requestBody;
    
    public function __construct(protected string $method, protected string $path)
    {
        $this->parameters = new Collection();
        $this->responses = new Collection(
            [
                200 => [
                    '$ref' => '#/components/responses/success_detail',
                ],
                500 => [
                    '$ref' => '#/components/responses/error_500',
                ],
            ]
        );
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
    
    public function parameter(string $name, array $args = [], bool $ref = false): static
    {
        if (!$ref) {
            $args['name'] = $name;
        }
        
        $this->parameters->put(
            $name,
            $args
        );
        
        return $this;
    }
    
    public function parameterRef(string $ref): static
    {
        return $this->parameter(
            $ref,
            [
                '$ref' => "#/components/parameters/{$ref}",
            ],
            true
        );
    }
    
    public function removeResponse(string $code)
    {
        return $this->responses->pull($code);
    }
    
    public function response(string $code, array $args = []): static
    {
        $this->responses->put(
            $code,
            $args
        );
        
        return $this;
    }
    
    public function responseRef(string $code, string $ref): static
    {
        return $this->response(
            $code,
            [
                '$ref' => "#/components/responses/{$ref}",
            ]
        );
    }
    
    public function setRequestBody(array $data)
    {
        $this->requestBody = new Collection($data);
    }
    
    public function toArray(): array
    {
        $data = [
            'tags' => $this->tags,
            'operationId' => $this->getOperationId(),
            'parameters' => $this->parameters->values(),
            'responses' => $this->responses,
        ];
        
        if (isset($this->summary)) {
            $data['summary'] = $this->summary;
        }
        
        if (isset($this->requestBody)) {
            $data['requestBody'] = $this->requestBody;
        }
        
        return $data;
    }
}
