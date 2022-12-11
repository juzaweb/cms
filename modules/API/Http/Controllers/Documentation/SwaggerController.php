<?php

namespace Juzaweb\API\Http\Controllers\Documentation;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Str;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Contracts\HookActionContract as HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;
use L5Swagger\Exceptions\L5SwaggerException;

class SwaggerController extends BackendController
{
    public function __construct(protected HookAction $hookAction)
    {
        do_action(Action::API_DOCUMENT_INIT);
    }
    
    /**
     * Display Swagger API page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        do_action(Action::API_DOCUMENT_INIT);
        
        $urls = $this->hookAction->getAPIDocuments()->map(
            function ($item, $name) {
                return [
                    'name' => Arr::get($item, 'info.title', Str::ucfirst($name)),
                    'url' => route('admin.api.documentation.json', [$name]),
                ];
            }
        )->values()->toArray();
        
        $useAbsolutePath = config('l5-swagger.documentations.default.paths.use_absolute_path');
        
        return ResponseFacade::make(
            view(
                'api::swagger.index',
                [
                    'secure' => RequestFacade::secure(),
                    'urls' => $urls,
                    'useAbsolutePath' => $useAbsolutePath,
                ]
            ),
            200
        );
    }
    
    /**
     * Display Oauth2 callback pages.
     *
     * @param  Request  $request
     * @return string
     *
     * @throws L5SwaggerException
     * @throws FileNotFoundException
     */
    public function oauth2Callback(Request $request): string
    {
        $fileSystem = new Filesystem();
        
        return $fileSystem->get(swagger_ui_dist_path('default', 'oauth2-redirect.html'));
    }
}
