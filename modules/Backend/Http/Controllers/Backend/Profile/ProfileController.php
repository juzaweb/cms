<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Backend\Http\Datatables\NotificationDatatable;
use Juzaweb\Backend\Http\Requests\User\ChangePasswordRequest;
use Juzaweb\Backend\Http\Requests\User\ProfileUpdateRequest;
use Juzaweb\Backend\Repositories\NotificationRepository;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Models\Language;

class ProfileController extends BackendController
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function index(): View
    {
        global $jw_user;

        $title = trans('cms::app.profile');

        $this->initLanguage();

        $dataTable = $this->getNotificationDataTable();

        $countries = config('countries');

        $languages = Language::get(['code', 'name'])
            ->mapWithKeys(
                function ($item) {
                    return [
                        $item->code => $item->name
                    ];
                }
            )
            ->toArray();

        return view(
            'cms::backend.profile.index',
            compact(
                'title',
                'jw_user',
                'dataTable',
                'languages',
                'countries'
            )
        );
    }

    public function notificationDatatable(Request $request): JsonResponse
    {
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);

        $table = $this->getNotificationDataTable();
        $query = $table->query($request->all());
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);

        $count = $query->count();
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

        return response()->json(
            [
                'total' => $count,
                'rows' => $results,
            ]
        );
    }

    public function update(ProfileUpdateRequest $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $metas = array_only($request->post('metas'), ['birthday', 'country']);

        DB::beginTransaction();
        try {
            $user->update($request->only(['name', 'language']));

            foreach ($metas as $key => $value) {
                $user->setMeta($key, $value);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(trans('cms::message.update_successfully'));
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $current = $request->post('current_password');
        $password = $request->post('password');

        if (!Hash::check($current, $user->password)) {
            return $this->error(trans('validation.current_password'));
        }

        $user->setAttribute('password', Hash::make($password));
        $user->save();

        return $this->success(
            trans('cms::message.change_password_successfully')
        );
    }

    public function notification($id): RedirectResponse|View
    {
        global $jw_user;

        $notification = $this->notificationRepository->find($id);

        if (empty($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        if ($notification->url) {
            return redirect()->to($notification->url);
        }

        $title = $notification->subject;

        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.profile'),
                'url' => route('admin.profile')
            ]
        );

        return view(
            'cms::backend.profile.index',
            compact(
                'title',
                'notification',
                'jw_user'
            )
        );
    }

    private function initLanguage(): void
    {
        if (!Language::exists()) {
            Language::create(
                [
                    'code' => 'en',
                    'name' => 'English',
                    'default' => true
                ]
            );
        }
    }

    private function getNotificationDataTable()
    {
        $dataTable = app(NotificationDatatable::class);
        $dataTable->setDataUrl(action([static::class, 'notificationDatatable']));
        return $dataTable;
    }
}
