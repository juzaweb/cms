<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function assetsPlugin($plugin, $path)
    {
        $path = str_replace('assets/', '', $path);
        $assetPath = plugin_path($plugin, 'src/resources/assets/' . $path);

        return $this->responsePath($assetPath);
    }

    protected function responsePath($path)
    {
        $path = $this->parsePathSecurity($path);
        if (! file_exists($path)) {
            return abort(404);
        }

        $contentType = $this->getStaticAssets($path);
        if (empty($contentType)) {
            return abort(404);
        }

        $content = file_get_contents($path);
        $response = Response::make($content, 200);
        $response->header('Content-Type', $contentType);
        $response->header('Cache-Control', 'public');

        return $response;
    }

    protected function parsePathSecurity($path)
    {
        return str_replace('..', '', $path);
    }

    protected function getStaticAssets($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $assets = [
            'js' => 'application/javascript',
            'css' => 'text/css',
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
            'mp4' => 'video/mp4',
            'webp' => 'image/webp',
            'tif' => 'image/tif',
            'tiff' => 'image/tiff',
        ];

        if (isset($assets[$extension])) {
            return $assets[$extension];
        }

        return false;
    }

    public function assetsTheme($theme, $path)
    {
        $path = str_replace('assets/', '', $path);
        $assetPath = Theme::getThemePath($theme) . '/assets/' . $path;

        return $this->responsePath($assetPath);
    }

    public function assetsStorage($path)
    {
        $path = Storage::disk('public')->path($path);

        return $this->responsePath($path);
    }

    public function languageScript($lang)
    {
        \Lang::setLocale($lang);

        $langs = \Lang::get('tad');
        $content = 'var langs = JSON.parse(\'' . json_encode($langs) . '\');';
        $response = Response::make($content, 200);
        $response->header('Content-Type', 'application/javascript');

        return $response;
    }
}
