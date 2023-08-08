<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Datatables\UserDataTable;
use Juzaweb\CMS\Http\Controllers\ApiController;

class DataTableController extends ApiController
{
    public function index()
    {
        //
    }

    public function show(Request $request): JsonResponse
    {
        $table = $this->getTable($request);

        return $this->restSuccess($table->toArray());
    }

    public function getData(Request $request): JsonResponse
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
                $results[$index][$col] = $row->{$col};
            }
        }

        return $this->restSuccess(
            [
                'total' => $count,
                'rows' => $results,
            ]
        );
    }

    private function getTable(Request $request): UserDataTable
    {
        $table = new UserDataTable();
        $table->mountData('posts');
        $table->currentUrl = $request->get('currentUrl');

        /*if (method_exists($table, 'mount')) {
            $data = json_decode(urldecode($request->get('data')), true);
            if ($data) {
                $table->mount(...$data);
            }
        }*/

        return $table;
    }
}
