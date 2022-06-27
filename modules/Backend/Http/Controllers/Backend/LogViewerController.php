<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Arcanedev\LogViewer\Contracts\LogViewer;
use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Juzaweb\CMS\Http\Controllers\BackendController;

class LogViewerController extends BackendController
{
    protected $perPage = 10;

    /**
     * The log viewer instance
     *
     * @var \Arcanedev\LogViewer\Contracts\LogViewer
     */
    protected $logViewer;

    public function __construct(LogViewer $logViewer)
    {
        $this->logViewer = $logViewer;
    }

    public function index()
    {
        $title = trans('cms::app.error_logs');

        return view(
            'cms::backend.logs.error.index',
            compact(
                'title'
            )
        );
    }

    public function show($date)
    {
        $this->addBreadcrumb([
            'title' => trans('cms::app.error_logs'),
            'url' => action([static::class, 'index']),
        ]);

        $this->getLogOrFail($date);
        $title = trans('cms::app.error_logs').' '.$date;

        return view(
            'cms::backend.logs.error.logs',
            compact(
                'title',
                'date'
            )
        );
    }

    public function listLogs(Request $request)
    {
        $stats = $this->logViewer->statsTable();
        $rows = $this->paginate($stats->rows(), $request);

        foreach ($rows as $index => $row) {
            $row['edit_url'] = route('admin.logs.error.date', [
                $row['date'],
            ]);
            $rows->put($index, $row);
        }

        return response()->json([
            'total' => count($stats->rows()),
            'rows' => $rows->values(),
        ]);
    }

    public function listLogsDate(Request $request, $date)
    {
        $level = 'all';
        $log = $this->getLogOrFail($date);
        $entries = $log->entries($level)->paginate($this->perPage);

        return response()->json([
            'total' => $entries->total(),
            'rows' => $entries->values(),
        ]);
    }

    /**
     * Delete a log.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $date = $request->input('date');

        return response()->json([
            'result' => $this->logViewer->delete($date) ? 'success' : 'error',
        ]);
    }

    /**
     * Paginate logs.
     *
     * @param array $data
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate(array $data, Request $request)
    {
        $data = new Collection($data);
        $page = $request->get('page', 1);
        $path = $request->url();

        return new LengthAwarePaginator(
            $data->forPage($page, 10),
            $data->count(),
            10,
            $page,
            compact('path')
        );
    }

    /**
     * Get a log or fail
     *
     * @param string $date
     *
     * @return \Arcanedev\LogViewer\Entities\Log|null
     */
    protected function getLogOrFail($date)
    {
        $log = null;

        try {
            $log = $this->logViewer->get($date);
        } catch (LogNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return $log;
    }
}
