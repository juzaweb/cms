<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/31/2021
 * Time: 9:55 PM
 */

namespace Mymo\Core\Supports;

use Illuminate\Http\Request;

class DataTable
{
    protected $datatable;

    public function __construct(string $datatable)
    {
        $this->datatable = $datatable;
    }

    public function jsonResponse()
    {
        $request = request();
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = $this->makeData()->query();
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    public function render()
    {
        $datatable = $this->makeData();
        return view('mymo::components.datatable', [
            'columns' => $datatable->columns()
        ]);
    }

    protected function makeData()
    {
        return (new ($this->datatable));
    }
}