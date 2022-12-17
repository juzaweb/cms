<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Models\ManualNotification;

class SendNotification
{
    protected ManualNotification $notification;
    
    public static function make(ManualNotification $notification): static
    {
        return new static($notification);
    }

    /**
     * @param  ManualNotification  $notification
     */
    public function __construct(ManualNotification $notification)
    {
        $this->notification = $notification;
    }

    public function send(): bool
    {
        $notifyMethods = $this->getMethods();
        $methods = explode(',', $this->notification->method);

        foreach ($notifyMethods as $key => $method) {
            if (!config("juzaweb.notification.via.{$key}.enable")) {
                continue;
            }

            if (!in_array($key, $methods)) {
                continue;
            }
    
            DB::beginTransaction();
            try {
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
                report($exception);
                
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
