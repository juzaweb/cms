<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Models\ManualNotification;

class SendNotification
{
    protected ManualNotification $notification;

    /**
     * @param ManualNotification $notification
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function send()
    {
        $notifyMethods = $this->getMethods();
        $methods = explode(',', $this->notification->method);

        foreach ($notifyMethods as $key => $method) {
            if (!config('juzaweb.notification.via.'. $key .'.enable')) {
                continue;
            }

            if (!in_array($key, $methods)) {
                continue;
            }

            try {
                DB::beginTransaction();
                (new $method['class']($this->notification))->handle();

                $this->notification->update(
                    [
                        'status' => ManualNotification::STATUS_SUCCESS,
                        'error' => null,
                    ]
                );

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();

                $this->notification->update(
                    [
                        'status' => ManualNotification::STATUS_ERROR,
                        'error' => $exception->getMessage(),
                    ]
                );

                return false;
            }
        }

        return true;
    }

    protected function getMethods()
    {
        return apply_filters('notify_methods', []);
    }
}
