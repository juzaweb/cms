<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Support\Facades\DB;
use Juzaweb\AdsManager\Repositories\AdsRepository;
use Juzaweb\CMS\Abstracts\DataTable;

class ResourceManagementDatatable extends DataTable
{
    protected AdsRepository $adsRepository;

    public function __construct(AdsRepository $adsRepository)
    {
        $this->adsRepository = $adsRepository;
    }

    public function columns()
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

    public function query($data)
    {
        $query = $this->adsRepository->query();

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        foreach ($ids as $id) {
            DB::beginTransaction();
            try {
                if ($action == 'delete') {
                    $this->adsRepository->delete($id);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
