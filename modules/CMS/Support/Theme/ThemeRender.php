<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
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

    public function render(string $view, array $params = []): Factory|View|string
    {
        switch ($this->theme->getTemplate()) {
            case 'twig':
                $params = $this->parseParamsForTwig($params);

                return apply_filters('theme.render_view', Twig::display($view, $params));
            default:
                return apply_filters('theme.render_view', view($view, $params));
        }
    }

    protected function parseParamsForTwig(array $params): array
    {
        if ($message = session('message')) {
            $params['message'] = $message;
        }

        if ($status = session('status')) {
            $params['status'] = $status;
        }

        foreach ($params as $key => $item) {
            if (is_a($item, 'Illuminate\Support\ViewErrorBag')) {
                continue;
            }

            if ($item instanceof Post) {
                $params[$key] = PostResource::make($item)->toArray(request());
            }

            if ($item instanceof Taxonomy) {
                $params[$key] = TaxonomyResource::make($item)->toArray(request());
            }

            if ($item instanceof Comment) {
                $params[$key] = CommentResource::make($item)->toArray(request());
            }

            if ($item instanceof EloquentCollection || $item instanceof LengthAwarePaginator) {
                $params[$key] = $this->parseParamEloquentCollectionForTwig($item);
            }

            if ($item instanceof Arrayable) {
                $item = $item->toArray();
                $params[$key] = $item;
            }

            if (!in_array(
                gettype($item),
                [
                    'boolean',
                    'integer',
                    'string',
                    'array',
                    'double',
                ]
            )
            ) {
                unset($params[$key]);
            }
        }

        return $params;
    }

    protected function parseParamEloquentCollectionForTwig(EloquentCollection $collection): array
    {
        if ($collection->isEmpty()) {
            return $collection->toArray();
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
