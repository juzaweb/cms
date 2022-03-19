<?php

namespace Juzaweb\Notification;

use Illuminate\Support\Facades\DB;

class SendNotification
{
    protected $notification;

    /**
     * @param \Juzaweb\Notification\Models\ManualNotification $notification
     * */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function send()
    {
        $notifyMethods = $this->getMethods();
        $methods = explode(',', $this->notification->method);

        foreach ($notifyMethods as $key => $method) {
            if (!config('notification.via.'. $key .'.enable')) {
                continue;
            }

            if (!in_array($key, $methods)) {
                continue;
            }

            try {
                DB::beginTransaction();
                (new $method['class']($this->notification))->handle();

                $this->notification->update([
                    'status' => 1,
                    'error' => null,
                ]);

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();

                $this->notification->update([
                    'status' => 0,
                    'error' => $exception->getMessage(),
                ]);

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
