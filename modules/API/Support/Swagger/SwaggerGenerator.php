<?php

namespace Juzaweb\API\Support\Swagger;

use Illuminate\Support\Collection;

class SwaggerGenerator
{
    protected Collection $versions;
    
    public function __construct()
    {
        $this->versions = new Collection();
    }
    
    public function addVersion(string $version, callable $callback): static
    {
        $this->versions->put(
            $version,
            $callback(new SwaggerVersion($version))
        );
        
        return $this;
    }
    
    public function getVersion(string $version): SwaggerVersion
    {
        return $this->versions->get($version);
    }
    
    public function getVersions(): Collection
    {
        return $this->versions;
    }
}
