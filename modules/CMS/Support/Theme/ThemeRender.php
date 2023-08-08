<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Theme;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Juzaweb\Backend\Http\Resources\CommentResource;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Contracts\Theme\ThemeRender as ThemeRenderContract;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;
use TwigBridge\Facade\Twig;

class ThemeRender implements ThemeRenderContract
{
    protected Request $request;

    public function __construct(protected ThemeInterface $theme)
    {
        $this->request = app('request');
    }

    public function render(string $view, array $params = []): Factory|View|string|\Inertia\Response
    {
        $params = $this->parseParams($params);

        return match ($this->theme->getTemplate()) {
            'twig' => apply_filters('theme.render_view', Twig::display($view, $params)),
            'inertia' => apply_filters('theme.render_view', $this->inertiaRender($view, $params)),
            default => apply_filters('theme.render_view', view($view, $params)),
        };
    }

    public function parseParams(array $params): array
    {
        foreach ($params as $key => $item) {
            $params[$key] = $this->parseParam($item);
        }

        switch ($this->theme->getTemplate()) {
            case 'twig':
                if ($message = session('message')) {
                    $params['message'] = $message;
                }

                if ($status = session('status')) {
                    $params['status'] = $status;
                }

                return $params;
            default:
                return $params;
        }
    }

    public function parseParam($param): mixed
    {
        return match ($this->theme->getTemplate()) {
            'twig', 'inertia' => $this->parseParamToArray($param),
            default => $param,
        };
    }

    protected function inertiaRender(string $view, array $params = []): \Inertia\Response
    {
        $view = Str::replace('theme::', '', $view);
        $view = Str::replace('.', '/', $view);
        return Inertia::render($view, $params);
    }

    protected function parseParamToArray($param)
    {
        if ($param instanceof \Illuminate\Support\ViewErrorBag) {
            return $param;
        }

        if ($param instanceof Post) {
            return PostResource::make($param)->toArray($this->request);
        }

        if ($param instanceof Taxonomy) {
            return TaxonomyResource::make($param)->toArray($this->request);
        }

        if ($param instanceof Comment) {
            return CommentResource::make($param)->toArray($this->request);
        }

        if ($param instanceof EloquentCollection || $param instanceof LengthAwarePaginator) {
            return $this->parseParamEloquentCollectionToArray($param);
        }

        if ($param instanceof Arrayable) {
            return $param->toArray();
        }

        if (!in_array(
            gettype($param),
            [
                'boolean',
                'integer',
                'string',
                'array',
                'double',
            ]
        )
        ) {
            return null;
        }

        return $param;
    }

    protected function parseParamEloquentCollectionToArray(EloquentCollection|LengthAwarePaginator $collection): array
    {
        if ($collection->isEmpty()) {
            return ResourceCollection::make($collection)->response()->getData(true);
        }

        if ($collection->first() instanceof Post) {
            return PostResourceCollection::make($collection)->response()->getData(true);
        }

        if ($collection->first() instanceof Comment) {
            return CommentResource::collection($collection)->response()->getData(true);
        }

        return $collection->toArray();
    }
}
