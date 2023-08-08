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

use Illuminate\Support\Collection;
use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\API\Support\Swagger\SwaggerMethod;
use Juzaweb\API\Support\Swagger\SwaggerPath;
use Juzaweb\CMS\Contracts\HookActionContract;

class PostTypeSwaggerDocumentation implements APISwaggerDocumentation
{
    public function __construct(protected HookActionContract $hookAction)
    {
    }

    public function handle(SwaggerDocument $document): SwaggerDocument
    {
        $postTypes = $this->hookAction->getPostTypes();

        foreach ($postTypes as $key => $postType) {
            $this->addPathPostType($key, $postType, $document);

            $taxonomies = $this->hookAction->getTaxonomies($key);

            foreach ($taxonomies as $tkey => $taxonomy) {
                $this->addPathTaxonomy($tkey, $taxonomy, $postType, $document);
            }
        }

        return $document;
    }

    private function addPathPostType(string $key, Collection $postType, $document)
    {
        $document->path(
            "post-type/{$key}",
            function (SwaggerPath $path) use ($key, $postType) {
                $path->method(
                    'get',
                    function (SwaggerMethod $method) use ($key, $postType) {
                        $method->operationId("post-type.{$key}.index");
                        $method->summary("Get list {$key} items");
                        $method->tags([$postType->get('label')]);
                        $method->parameterRef('query_keyword');
                        $method->parameterRef('query_limit');
                        $method->responseRef(200, 'success_list');
                        return $method;
                    }
                );
                return $path;
            }
        );
        $document->path(
            "post-type/{$key}/{slug}",
            function (SwaggerPath $path) use ($key, $postType) {
                $path->method(
                    'get',
                    function (SwaggerMethod $method) use ($key, $postType) {
                        $method->operationId("post-type.{$key}.show");
                        $method->summary("Get {$key} item");
                        $method->tags([$postType->get('label')]);
                        $method->parameterRef('path_slug');
                        return $method;
                    }
                );
                return $path;
            }
        );
    }

    private function addPathTaxonomy(string $key, Collection $taxonomy, Collection $postType, $document)
    {
        $document->path(
            "taxonomy/{$postType->get('key')}/{$key}",
            function (SwaggerPath $path) use ($key, $taxonomy, $postType) {
                $path->method(
                    'get',
                    function (SwaggerMethod $method) use ($key, $taxonomy, $postType) {
                        $method->operationId("post-type.{$key}.index");
                        $method->summary("Get list {$key} items");
                        $method->tags([$postType->get('label')]);
                        $method->parameterRef('query_keyword');
                        $method->parameterRef('query_limit');
                        $method->responseRef(200, 'success_list');
                        return $method;
                    }
                );
                return $path;
            }
        );
        $document->path(
            "taxonomy/{$postType->get('key')}/{$key}/{slug}",
            function (SwaggerPath $path) use ($key, $taxonomy, $postType) {
                $path->method(
                    'get',
                    function (SwaggerMethod $method) use ($key, $taxonomy, $postType) {
                        $method->operationId("post-type.{$key}.show");
                        $method->summary("Get {$key} item");
                        $method->tags([$postType->get('label')]);
                        $method->parameterRef('path_slug');
                        return $method;
                    }
                );
                return $path;
            }
        );
    }
}
