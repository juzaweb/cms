<?php

namespace Tadcms\Notification;

use Illuminate\Support\Facades\DB;

class SendNotification
{
    protected $notification;

    /**
     * @param \Tadcms\Notification\Models\ManualNotification $notification
     * */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function send()
    {
        $notifyMethods = $this->getMethods();
        foreach ($notifyMethods as $key => $method) {
            if (config('notification.via.'. $key .'.enable')) {
                try {
                    DB::beginTransaction();
                    (new $method['class']($this->notification))->handle();

                    $this->notification->update([
                        'status' => 1
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
        }

        return true;
    }

    protected function getMethods()
    {
        return apply_filters('notify_methods', []);
    }
}
