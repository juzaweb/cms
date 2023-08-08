<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Repositories\BaseRepository;

class ResourceManagementDatatable extends DataTable
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function columns(): array
    {
        return [
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
        ];
    }

    public function query($data): Builder
    {
        return $this->repository->query();
    }

    public function bulkActions($action, $ids)
    {
        foreach ($ids as $id) {
            DB::beginTransaction();
            try {
                if ($action == 'delete') {
                    $this->repository->delete($id);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
