<?php

namespace Juzaweb\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\Support\SendEmail;
use Juzaweb\Traits\MultisiteCli;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use MultisiteCli;

    protected $mail;
    protected $siteId;

    /**
     * Create a new job instance.
     *
     * @param EmailList $mail
     * @param int $siteId
     * @return void
     */
    public function __construct($mail, $siteId)
    {
        $this->mail = $mail;
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

        (new SendEmail($this->mail))->send();
    }
}
