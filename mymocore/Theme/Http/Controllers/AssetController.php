<?php

namespace Mymo\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class AssetController extends Controller
{
    public function assetModule($module, $path) {
        $content_type = $this->getStaticAssets($path);
        
        $content = '';
        $file = base_path('Modules/' . $module . '/assets/' . $path);
        
        if (file_exists($file)) {
            $content = file_get_contents($file);
        }
        
        $response = Response::make($content, 200);
        $response->header('Content-Type', $content_type);
        $response->header('Cache-Control', 'public');
        return $response;
    }
    
    public function languageScript($lang) {
        \Lang::setLocale($lang);
        
        $langs = \Lang::get('tad');
        $content = 'var langs = JSON.parse(\'' . json_encode($langs) . '\');';
        $response = Response::make($content, 200);
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }
    
    protected function getStaticAssets($path) {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        $assets = [
            'js' => 'application/javascript',
            'css' => 'application/octet-stream',
            'woff' => 'application/font-woff',
            'woff2' => 'application/font-woff2',
            'ttf' => 'application/font-ttf',
            'pdf' => 'application/pdf',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'svg' => 'image/svg+xml',
            'ts' => 'video/mp2t',
            'webp' => 'image/webp',
            'tif' => 'image/tif',
            'tiff' => 'image/tiff',
        ];
        
        if (isset($assets[$extension])) {
            return $assets[$extension];
        }
        
        return 'text/plain';
    }
}
