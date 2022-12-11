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
use Juzaweb\API\Support\Swagger\SwaggerVersion;
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
        $apiAdmin = new SwaggerDocument(
            'admin',
            [
                'title' => 'Admin',
            ]
        );
        
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
