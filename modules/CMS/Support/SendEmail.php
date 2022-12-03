<?php

namespace Juzaweb\CMS\Support;

use Exception;
use Illuminate\Support\Facades\Mail;
use Juzaweb\Backend\Models\EmailList;

class SendEmail
{
    protected EmailList $mail;

    public function __construct(EmailList $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Send email by row email_lists table
     *
     * @return bool
     * @throws Exception
     */
    public function send(): bool
    {
        $validate = $this->validate();
        if ($validate !== true) {
            $this->updateError($validate);
            return false;
        }

        $this->updateStatus('processing');

        try {
            $body = $this->mail->getBody();
            $subject = $this->mail->getSubject();

            Mail::send(
                'cms::backend.email.layouts.default',
                [
                    'body' => $body,
                ],
                function ($message) use ($subject) {
                    $message->to([$this->mail->email])
                        ->subject($subject);
                }
            );

            /*if (Mail::failures()) {
                $this->updateError(array_merge([
                    'title' => 'Mail failures',
                ], Mail::failures()));

                return false;
            }*/

            $this->updateStatus('success', $subject, $body);

            return true;
        } catch (Exception $e) {
            $this->updateError(
                [
                    'title' => 'Send mail exception',
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                ]
            );

            if (config('app.debug')) {
                throw $e;
            }
            report($e);
            return false;
        }
    }

    protected function updateStatus(
        string $status,
        $subject = null,
        $body = null
    ): bool {
        $update = [
            'status' => $status
        ];

        if ($subject && $body) {
            $data = $this->mail->data;
            $data['subject'] = $subject;
            $data['body'] = $body;
            $update['data'] = $data;
        }

        return $this->mail->update($update);
    }

    protected function updateError(array $error = []): bool
    {
        return $this->mail->update(
            [
                'error' => $error,
                'status' => 'error',
            ]
        );
    }

    /**
     * Send mail validate
     *
     * @return bool|array
     */
    protected function validate(): bool|array
    {
        return true;
    }
}
