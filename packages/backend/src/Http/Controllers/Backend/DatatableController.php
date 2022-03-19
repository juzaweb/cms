<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\Http\Controllers\BackendController;

class DatatableController extends BackendController
{
    public function getData(Request $request)
    {
        $table = $this->getTable($request);
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);

        $query = $table->query($request->all());
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        $results = [];
        $columns = $table->columns();

        foreach ($rows as $index => $row) {
            $columns['id'] = $row->id;
            foreach ($columns as $col => $column) {
                if (! empty($column['formatter'])) {
                    $results[$index][$col] = $column['formatter'](
                        $row->{$col} ?? null,
                        $row,
                        $index
                    );
                } else {
                    $results[$index][$col] = $row->{$col};
                }
            }
        }

        return response()->json([
            'total' => $count,
            'rows' => $results,
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

        $table = $this->getTable($request);
        $table->bulkActions($action, $ids);

        return $this->success([
            'message' => trans('cms::app.successfully'),
        ]);
    }

    /**
     * Get datatable
     *
     * @param Request $request
     * @return DataTable
     */
    protected function getTable($request)
    {
        $table = Crypt::decryptString($request->get('table'));
        $table = app($table);
        $table->currentUrl = $request->get('currentUrl');

        if (method_exists($table, 'mount')) {
            $data = json_decode(urldecode($request->get('data')), true);
            $table->mount(...$data);
        }

        return $table;
    }
}
