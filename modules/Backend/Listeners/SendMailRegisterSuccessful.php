<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Listeners;

use Illuminate\Support\Str;
use Juzaweb\CMS\Events\EmailHook;
use Juzaweb\Backend\Events\RegisterSuccessful;

class SendMailRegisterSuccessful
{
    /**
     * Handle the event.
     *
     * @param RegisterSuccessful $event
     * @return void
     */
    public function handle(RegisterSuccessful $event): void
    {
        if (get_config('user_verification')) {
            $verifyToken = Str::random(32);

            $event->user->update(
                [
                    'status' => 'verification',
                    'verification_token' => $verifyToken,
                ]
            );

            event(
                new EmailHook(
                    'register_success',
                    [
                        'to' => [$event->user->email],
                        'params' => [
                            'name' => $event->user->name,
                            'email' => $event->user->email,
                            'verifyToken' => $verifyToken,
                            'verifyUrl' => route(
                                'verification',
                                [$event->user->email, $verifyToken]
                            ),
                        ],
                    ]
                )
            );
        }

        event(
            new EmailHook(
                'register_success',
                [
                    'params' => [
                        'name' => $event->user->name,
                        'email' => $event->user->email,
                    ],
                ]
            )
        );
    }
}
