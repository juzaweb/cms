<?php

namespace Juzaweb\CMS\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Juzaweb\Backend\Models\ManualNotification;
use Juzaweb\CMS\Support\SendNotification as CMSSendNotification;

class SendNotification implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $notification;

    public $timeout = 3600;

    /**
     * Create a new job instance.
     *
     * @param ManualNotification $notification
     * @return void
     */
    public function __construct(ManualNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        (new CMSSendNotification($this->notification))->send();
    }
}
