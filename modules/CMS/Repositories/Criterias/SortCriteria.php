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
use Illuminate\Http\Request;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

class SortCriteria implements CriteriaInterface
{
    protected Request $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fields = $repository->getFieldSortable();
        $tbl = $model->getModel()->getTable();
        $sortBy = $this->request->input('sort_by');
        $sortOrder = $this->request->input('sort_order', 'ASC');
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        
        if ($sortBy && in_array($sortBy, $fields)) {
            $model = $model->orderBy("{$tbl}.{$sortBy}", $sortOrder);
        } else {
            $defaults = $repository->getSortableDefaults();
            if ($defaults) {
                foreach ($defaults as $col => $order) {
                    $model = $model->orderBy("{$tbl}.{$col}", $order);
                }
            }
        }
        
        return $model;
    }
}
