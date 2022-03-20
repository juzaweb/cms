<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Translation\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Juzaweb\Abstracts\DataTable;

class TranslationDatatable extends DataTable
{
    protected $locale;

    public function mount($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'object_key' => [
                'label' => trans('cms::app.type'),
                'width' => '10%',
            ],
            'value' => [
                'label' => trans('cms::app.origin'),
                'width' => '30%',
            ],
            'translate' => [
                'label' => trans('cms::app.translate'),
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    $trans = $row->value;
                    if ($row->text) {
                        $text = json_decode($row->text, true);
                        if ($line = Arr::get($text, $this->locale)) {
                            $trans = $line;
                        }
                    }

                    return '<input 
                    type="text" 
                    class="form-control translate" 
                    data-namespace="'. $row->namespace .'"
                    data-group="'. $row->group .'"
                    data-key="'. $row->key .'"
                    '. ($value == 1 ? 'checked': '') .' 
                    value="'. e($trans) .'" />';
                },
            ],
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $tbPrefix = DB::getTablePrefix();
        $tbPrefixTrans = DB::connection('pgsql')->getTablePrefix();

        $objects = [
            'theme_' . jw_current_theme(),
        ];

        DB::setTablePrefix('');
        $query = DB::table("{$tbPrefixTrans}jw_translations AS a");
        $query->select([
            'a.*',
            'b.text'
        ]);

        $query->leftJoin("{$tbPrefix}language_lines AS b", function ($q) {
            $q->on('a.key', '=', 'b.key');
            $q->on('a.group', '=', 'b.group');
            $q->on('a.namespace', '=', 'b.namespace');
        });

        $query->where('a.locale', '=', 'en');
        $query->whereIn('a.object_key', $objects);

        if ($search = Arr::get($data, 'keyword')) {
            $query->where(function ($q) use ($search) {
                $q->where('a.group', JW_SQL_LIKE, "%{$search}%");
                $q->orWhere('a.key', JW_SQL_LIKE, "%{$search}%");
                $q->orWhere('a.value', JW_SQL_LIKE, "%{$search}%");
                $q->orWhere('a.object_key', JW_SQL_LIKE, "%{$search}%");
                $q->orWhere('b.text', JW_SQL_LIKE, "%{$search}%");
            });
        }

        return $query;
    }

    public function actions()
    {
        return [];
    }
}
