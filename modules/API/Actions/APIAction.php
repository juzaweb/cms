<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Actions;

use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\API\Support\Swagger\SwaggerMethod;
use Juzaweb\API\Support\Swagger\SwaggerPath;
use Juzaweb\CMS\Abstracts\Action;

class APIAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenu']);
        $this->addAction(Action::API_DOCUMENT_INIT, [$this, 'addDocumentation'], 1);
    }
    
    public function addDocumentation()
    {
        $postTypes = $this->hookAction->getPostTypes();
        $taxonomies = $this->hookAction->getTaxonomies();
        
        $apiAdmin = new SwaggerDocument(
            'admin',
            [
                'title' => 'Admin',
            ]
        );
        
        foreach ($postTypes as $key => $postType) {
            $apiAdmin->addPath(
                "post-type/{$key}",
                function (SwaggerPath $path) use ($key, $postType) {
                    $path->addMethod(
                        'get',
                        function (SwaggerMethod $method) use ($key, $postType) {
                            $method->operationId("admin.post-type.{$key}.index");
                            $method->summary("Get list {$key} items");
                            $method->tags(['Post Type']);
                            $method->parameter(
                                'keyword',
                                [
                                    '$ref' => '#/components/parameters/query_keyword',
                                ]
                            );
                            $method->parameter(
                                'limit',
                                [
                                    '$ref' => '#/components/parameters/query_limit',
                                ]
                            );
                            return $method;
                        }
                    );
                    return $path;
                }
            );
        }
        
        $this->hookAction->registerAPIDocument($apiAdmin);
    }
    
    public function addAdminMenu()
    {
        $this->hookAction->registerAdminPage(
            'api.documentation',
            [
                'title' => trans('cms::app.api_documentation'),
                'menu' => [
                    'icon' => 'fa fa-book',
                    'position' => 95,
                ],
            ]
        );
    }
}
