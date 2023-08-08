<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Http\Controllers\BackendController;

class DatatableController extends BackendController
{
    public function getData(Request $request): JsonResponse
    {
        $table = $this->getTable($request);
        list($count, $rows) = $table->getData($request);

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

        return response()->json(
            [
                'total' => $count,
                'rows' => $results,
            ]
        );
    }

    public function bulkActions(Request $request): JsonResponse
    {
        $request->validate(
            [
                'ids' => 'required|array',
                'action' => 'required',
            ]
        );

        $action = $request->post('action');
        $ids = $request->post('ids');

        $table = $this->getTable($request);
        $table->bulkActions($action, $ids);

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
            ]
        );
    }

    /**
     * Get datatable
     *
     * @param Request $request
     * @return DataTable
     */
    protected function getTable(Request $request): DataTable
    {
        $table = Crypt::decryptString($request->get('table'));
        $table = app($table);
        $table->currentUrl = $request->get('currentUrl');

        if (method_exists($table, 'mount')) {
            $data = json_decode(urldecode($request->get('data')), true);
            if ($data) {
                $table->mount(...$data);
            }
        }

        return $table;
    }
}
