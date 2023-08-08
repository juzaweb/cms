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

use Arcanedev\LogViewer\Contracts\LogViewer;
use Arcanedev\LogViewer\Entities\Log;
use Arcanedev\LogViewer\Entities\LogEntry;
use Arcanedev\LogViewer\Entities\LogEntryCollection;
use Arcanedev\LogViewer\Exceptions\FilesystemException;
use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\CMS\Http\Controllers\BackendController;

class LogViewerController extends BackendController
{
    protected int $perPage = 10;

    protected string $showRoute = 'admin.logs.error.show';

    public function __construct(protected LogViewer $logViewer)
    {
    }

    public function index(): View
    {
        $title = trans('cms::app.error_logs');

        return view(
            'cms::backend.logs.error.index',
            compact(
                'title'
            )
        );
    }

    public function show(Request $request, string $date): View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.error_logs'),
                'url' => action([static::class, 'index']),
            ]
        );

        $level = 'all';
        $title = trans('cms::app.error_logs').' '.$date;
        $log = $this->getLogOrFail($date);
        $query = $request->get('query');
        $levels = $this->logViewer->levelsNames();
        $entries = $log->entries($level)->paginate($this->perPage);

        return view(
            'cms::backend.logs.error.show',
            compact(
                'title',
                'date',
                'level',
                'log',
                'query',
                'levels',
                'entries'
            )
        );
    }

    public function listLogs(Request $request): JsonResponse
    {
        $stats = $this->logViewer->statsTable();
        $rows = $this->paginate($stats->rows(), $request);

        foreach ($rows as $index => $row) {
            $row['edit_url'] = route(
                'admin.logs.error.show',
                [
                    $row['date'],
                ]
            );
            $rows->put($index, $row);
        }

        return response()->json(
            [
                'total' => count($stats->rows()),
                'rows' => $rows->values(),
            ]
        );
    }

    /**
     * Show the log with the search query.
     *
     * @param Request $request
     * @param string $date
     * @param string $level
     *
     * @return RedirectResponse|View
     */
    public function search(Request $request, string $date, string $level = 'all'): RedirectResponse|View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.error_logs'),
                'url' => action([static::class, 'index']),
            ]
        );

        $title = trans('cms::app.error_logs').' '.$date;
        $query = $request->get('query');
        if (is_null($query)) {
            return redirect()->route($this->showRoute, [$date]);
        }

        $log = $this->getLogOrFail($date);
        $levels = $this->logViewer->levelsNames();
        $needles = array_map(
            function ($needle) {
                return Str::lower($needle);
            },
            array_filter(explode(' ', $query))
        );

        $entries = $log->entries($level)
            ->unless(
                empty($needles),
                function (LogEntryCollection $entries) use ($needles) {
                    return $entries->filter(
                        function (LogEntry $entry) use ($needles) {
                            foreach ([$entry->header, $entry->stack, $entry->context()] as $subject) {
                                if (Str::containsAll(Str::lower($subject), $needles)) {
                                    return true;
                                }
                            }

                            return false;
                        }
                    );
                }
            )
            ->paginate($this->perPage);

        return view(
            'cms::backend.logs.error.show',
            compact('title', 'level', 'log', 'query', 'levels', 'entries')
        );
    }

    /**
     * Delete a log.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws FilesystemException
     */
    public function delete(Request $request): JsonResponse
    {
        $date = $request->input('date');

        return response()->json(
            [
                'result' => $this->logViewer->delete($date) ? 'success' : 'error',
            ]
        );
    }

    public function download($date): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->logViewer->download($date);
    }

    /**
     * Paginate logs.
     *
     * @param array $data
     * @param Request $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate(array $data, Request $request): LengthAwarePaginator
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
     * @return Log|null
     */
    protected function getLogOrFail(string $date): ?Log
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
