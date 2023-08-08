<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\Email;

class EmailController extends BackendController
{
    public function save(Request $request): JsonResponse|RedirectResponse
    {
        $email = $request->only(
            [
                'email.host',
                'email.port',
                'email.encryption',
                'email.username',
                'email.password',
                'email.from_address',
                'email.from_name',
            ]
        );

        $email = $email['email'];

        set_config('email', $email);

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
            ]
        );
    }

    public function sendTestMail(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(
            [
                'email' => 'required|email',
            ]
        );

        $email = $request->post('email');
        Email::make()
            ->setEmails($email)
            ->setSubject('Send email for {{ name }}')
            ->setBody(
                'Hello {{ name }}, If you receive this email, it means that your config email on Juzaweb is active.'
            )
            ->setParams(['name' => Auth::user()->name])
            ->send();

        return $this->success(
            [
                'message' => trans('cms::app.send_mail_successfully'),
            ]
        );
    }
}
