<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageCache;
use Juzaweb\CMS\Contracts\TranslationManager;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\Controller;

class AssetController extends Controller
{
    private int $cacheAge = 86400;

    public function __construct(protected TranslationManager $translationManager)
    {
    }

    public function assetPlugin($vendor, $plugin, $path): HttpResponse
    {
        $path = str_replace('assets/', '', $path);
        $assetPath = plugin_path("{$vendor}/{$plugin}", 'assets/public/' . $path);
        return $this->responseWithPath($assetPath);
    }

    public function assetTheme($theme, $path): HttpResponse
    {
        $path = str_replace('assets/', '', $path);
        $assetPath = ThemeLoader::getPath($theme, 'assets/public/' . $path);
        return $this->responseWithPath($assetPath);
    }

    public function assetStorage(string $path): HttpResponse
    {
        $path = Storage::disk('public')->path($path);

        return $this->responseWithPath($path);
    }

    public function proxyImage(string $method, string $size, string $path)
    {
        $path = Storage::disk('public')->path($path);
        if (!file_exists($path)) {
            $path = public_path('jw-styles/juzaweb/images/thumb-default.png');
        }

        list($width, $height) = explode('x', $size);
        $width = $width == 'auto' ? null : $width;
        $height = $height == 'auto' ? null : $height;
        $aspectRatio = empty($width) || empty($height) ? fn($constraint) => $constraint->aspectRatio() : null;

        $img = match ($method) {
            'fit', 'crop' => Image::cache(
                fn(ImageCache $image) => $image->make($path)->{$method}(
                    $width,
                    $height
                ),
                60,
                true
            ),
            default => Image::cache(
                fn(ImageCache $image) => $image->make($path)->resize(
                    $width,
                    $height,
                    $aspectRatio
                ),
                60,
                true
            ),
        };

        return $img->response()
            ->header('accept-ranges', 'bytes')
            ->setCache(['public' => true, 'max_age' => $this->cacheAge, 's_maxage' => $this->cacheAge]);
    }

    public function languageScript($lang): HttpResponse
    {
        Lang::setLocale($lang);

        $cacheFile = 'cache/lang-js.js';

        if (Storage::fileExists($cacheFile) && !config('app.debug')) {
            $path = Storage::path($cacheFile);
            $content = File::get($path);
            $length = Storage::size($cacheFile);
        } else {
            $langs['cms'] = Lang::get('cms::app');
            $content = 'const langs = '. json_encode($langs);
            Storage::put($cacheFile, $content);
            $length = Storage::size($cacheFile);
        }

        $response = Response::make($content);
        $response->header('Content-Type', 'application/javascript');
        $response->header('accept-ranges', 'bytes');
        $response->header('content-length', $length);
        $response->setCache(['public' => true, 'max_age' => $this->cacheAge, 's_maxage' => $this->cacheAge]);
        return $response;
    }

    protected function responseWithPath($path): HttpResponse
    {
        $path = $this->parsePathSecurity($path);
        if (! file_exists($path)) {
            abort(404);
        }

        $contentType = $this->getStaticAssets($path);
        if (empty($contentType)) {
            abort(404);
        }

        $content = File::get($path);
        $response = Response::make($content);
        $response->header('Content-Type', $contentType);
        $response->header('content-length', File::size($path));
        $response->header('accept-ranges', 'bytes');
        $response->setCache(['public' => true, 'max_age' => $this->cacheAge, 's_maxage' => $this->cacheAge]);
        return $response;
    }

    protected function parsePathSecurity($path): string
    {
        return str_replace('.php', '', $path);
    }

    protected function getStaticAssets($path): string
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

        return $assets[$extension] ?? 'text/plain';
    }
}
