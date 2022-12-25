<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Repositories\Abstracts\Criteria;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

class SortCriteria extends Criteria implements CriteriaInterface
{
    public function __construct(protected ?array $queries = null)
    {
        if (is_null($this->queries)) {
            $this->queries = request()->all();
        }
    }
    
    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model     $model
     * @param RepositoryInterface $repository
     *
     * @return Builder|Model
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository): Builder|Model
    {
        if (!method_exists($repository, 'getFieldSortable')) {
            return $model;
        }
        
        $fields = $repository->getFieldSortable();
        $tbl = $model->getModel()->getTable();
        $sortBy = Arr::get($this->queries, 'sort_by');
        $sortOrder = Arr::get($this->queries, 'sort_order', 'ASC');
        
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        
        if ($sortBy && in_array($sortBy, $fields)) {
            return $model->orderBy("{$tbl}.{$sortBy}", $sortOrder);
        }
    
        if (!method_exists($repository, 'getSortableDefaults')) {
            return $model;
        }
        
        $defaults = $repository->getSortableDefaults();
        if ($defaults) {
            foreach ($defaults as $col => $order) {
                $model->orderBy("{$tbl}.{$col}", $order);
            }
        }
        
        return $model;
    }
}
