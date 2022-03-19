<?php

namespace Juzaweb\Notification\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Juzaweb\Notification\Models\ManualNotification;
use Juzaweb\Notification\SendNotification as TadNotification;
use Juzaweb\Traits\MultisiteCli;

class SendNotification implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        MultisiteCli;

    protected $notification;

    protected $siteId;

    public $timeout = 3600;

    /**
     * Create a new job instance.
     *
     * @param ManualNotification $notification
     * @param int $siteId
     * @return void
     */
    public function __construct($notification, $siteId)
    {
        $this->notification = $notification;
        $this->siteId = $siteId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->setUpSite($this->siteId);

        (new TadNotification($this->notification))->send();
    }
}
