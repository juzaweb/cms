<?php

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Jobs\SendEmailJob;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\Backend\Models\EmailTemplate;

class Email
{
    protected $emails;
    protected $template;
    protected $params = [];
    protected $priority = 1;
    protected $subject;
    protected $body;

    /**
     * Make email service
     * */
    public static function make()
    {
        return new Email();
    }

    /**
     * Set template for email by template code
     *
     * @param string $templateCode
     * @return $this
     * */
    public function withTemplate(string $templateCode)
    {
        $this->template = $templateCode;

        return $this;
    }

    /**
     * Set emails will send
     *
     * @param string|array $emails
     * @return $this
     * */
    public function setEmails($emails)
    {
        if (is_array($emails)) {
            $this->emails = array_unique($emails);
        } else {
            $this->emails = [$emails];
        }

        return $this;
    }

    /**
     * Set params for email
     *
     * @param array $params
     * @return $this
     * */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function send()
    {
        $templateId = $this->validate();
        $data = [];

        if ($this->subject) {
            $data['subject'] = $this->subject;
        }

        if ($this->body) {
            $data['body'] = $this->body;
        }

        foreach ($this->emails as $email) {
            $emailList = EmailList::create(
                [
                    'email' => $email,
                    'template_id' => $templateId,
                    'params' => $this->params,
                    'priority' => $this->priority,
                    'data' => $data,
                ]
            );

            $method = config('juzaweb.email.method');
            switch ($method) {
                case 'sync':
                    (new SendEmail($emailList))->send();
                    break;
                case 'queue':
                    SendEmailJob::dispatch($emailList);
                    break;
            }
        }

        return true;
    }

    protected function validate()
    {
        if (empty($this->template)) {
            return null;
        }

        $template = EmailTemplate::where(['code' => $this->template])->first(['id']);
        if (empty($template)) {
            throw new \Exception("Email template [{$this->template}] does not exist.");
        }

        return $template->id;
    }
}
