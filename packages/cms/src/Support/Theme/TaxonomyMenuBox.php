<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Theme;

use Juzaweb\Abstracts\MenuBox;
use Juzaweb\Backend\Facades\HookAction;

class TaxonomyMenuBox extends MenuBox
{
    protected $key;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $taxonomy;

    public function __construct($key, $taxonomy)
    {
        $this->key = $key;
        $this->taxonomy = $taxonomy;
    }

    public function mapData($data)
    {
        $result = [];
        $items = $data['items'];

        /**
         * @var \Illuminate\Database\Eloquent\Builder $query
         */
        $query = app($this->taxonomy->get('model'))->query();
        $items = $query->whereIn('id', $items)->get();

        foreach ($items as $item) {
            $result[] = $this->getData([
                'label' => $item->name,
                'model_id' => $item->id,
            ]);
        }

        return $result;
    }

    public function getData($item)
    {
        return [
            'label' => $item['label'],
            'model_class' => $this->taxonomy->get('model'),
            'model_id' => $item['model_id'],
        ];
    }

    public function addView()
    {
        return view('cms::backend.menu.boxs.taxonomy_add', [
            'taxonomy' => $this->taxonomy,
            'key' => $this->key,
        ]);
    }

    public function editView($item)
    {
        return view('cms::backend.menu.boxs.taxonomy_edit', [
            'taxonomy' => $this->taxonomy,
            'key' => $this->key,
            'item' => $item,
        ]);
    }

    public function getLinks($menuItems)
    {
        $permalink = HookAction::getPermalinks($this->taxonomy->get('taxonomy'));
        $base = $permalink->get('base');
        $query = app($this->taxonomy->get('model'))->query();
        $items = $query->whereIn('id', $menuItems->pluck('model_id')->toArray())
            ->get(['id', 'slug'])->keyBy('id');

        return $menuItems->map(function ($item) use ($base, $items) {
            if (! empty($items[$item->model_id])) {
                $item->link = url()->to($base . '/' . $items[$item->model_id]->slug);
            }

            return $item;
        });
    }
}
