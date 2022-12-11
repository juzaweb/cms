<?php

namespace Juzaweb\API\Http\Controllers\Documentation;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Juzaweb\CMS\Http\Controllers\BackendController;
use L5Swagger\Exceptions\L5SwaggerException;
use L5Swagger\GeneratorFactory;

class SwaggerController extends BackendController
{
    public function __construct(protected GeneratorFactory $generatorFactory)
    {
        $this->generatorFactory = $generatorFactory;
    }
    
    /**
     * Display Swagger API page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $urls = [];
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
