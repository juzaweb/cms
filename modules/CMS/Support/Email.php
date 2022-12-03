<?php

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Jobs\SendEmailJob;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\Backend\Models\EmailTemplate;

class Email
{
    protected array $emails;
    protected string $template;
    protected array $params = [];
    protected int $priority = 1;
    protected string $subject;
    protected string $body;

    /**
     * Make email service
     * */
    public static function make(): Email
    {
        return new Email();
    }

    /**
     * Set template for email by template code
     *
     * @param string $templateCode
     * @return $this
     * */
    public function withTemplate(string $templateCode): static
    {
        $this->template = $templateCode;

        return $this;
    }

    /**
     * Set emails will send
     *
     * @param array|string $emails
     * @return $this
     */
    public function setEmails(array|string $emails): static
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
     */
    public function setParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function setSubject($subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function setBody($body): static
    {
        $this->body = $body;

        return $this;
    }

    public function send(): bool
    {
        $templateId = $this->validate();
        $data = [];

        if (isset($this->subject)) {
            $data['subject'] = $this->subject;
        }

        if (isset($this->body)) {
            $data['body'] = $this->body;
        }

        foreach ($this->emails as $email) {
            $emailList = EmailList::create(
                [
                    'email' => $email,
                    'template_id' => $templateId,
                    'template_code' => $this->template,
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

    protected function validate(): ?int
    {
        if (empty($this->template)) {
            return null;
        }

        $template = EmailTemplate::where(['code' => $this->template])->first(['id']);
        if (empty($template)) {
            return null;
        }

        return $template->id;
    }
}
