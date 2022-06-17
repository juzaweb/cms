<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Collection;

class Facades
{
    public static function defaultServiceProviders(): array
    {
        return [
            /*
            * Laravel Framework Service Providers...
            */
            \Illuminate\Auth\AuthServiceProvider::class,
            \Illuminate\Broadcasting\BroadcastServiceProvider::class,
            \Illuminate\Bus\BusServiceProvider::class,
            \Illuminate\Cache\CacheServiceProvider::class,
            \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
            \Illuminate\Cookie\CookieServiceProvider::class,
            \Illuminate\Database\DatabaseServiceProvider::class,
            \Illuminate\Encryption\EncryptionServiceProvider::class,
            \Illuminate\Filesystem\FilesystemServiceProvider::class,
            \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
            \Illuminate\Hashing\HashServiceProvider::class,
            \Illuminate\Mail\MailServiceProvider::class,
            \Illuminate\Notifications\NotificationServiceProvider::class,
            \Illuminate\Pagination\PaginationServiceProvider::class,
            \Illuminate\Pipeline\PipelineServiceProvider::class,
            \Illuminate\Queue\QueueServiceProvider::class,
            \Illuminate\Redis\RedisServiceProvider::class,
            \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
            \Illuminate\Session\SessionServiceProvider::class,
            \Spatie\TranslationLoader\TranslationServiceProvider::class,
            \Illuminate\Validation\ValidationServiceProvider::class,
            \Illuminate\View\ViewServiceProvider::class,

            /*
             * Package Service Providers...
             */
            \Juzaweb\CMS\Providers\CmsServiceProvider::class,
            \Juzaweb\Backend\Providers\BackendServiceProvider::class,
        ];
    }

    public static function defaultConfigs(): array
    {
        return [
            'title',
            'description',
            'banner',
            'logo',
            'icon',
            'banner',
            'sitename',
            'user_registration',
            'user_verification',
            'comment_able',
            'comment_type',
            'comments_per_page',
            'comments_approval',
            'author_name',
            'facebook',
            'twitter',
            'pinterest',
            'youtube',
            'google_analytics',
            'language',
            'timezone',
            'date_format',
            'time_format',
            'fb_app_id',
            'backend_messages',
            'socialites',
            'posts_per_page',
            'posts_per_rss',
        ];
    }

    public static function defaultImageMimetypes(): array
    {
        return [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif',
            'image/svg+xml',
        ];
    }

    public static function defaultSVGMimetypes(): array
    {
        return [
            'image/svg+xml',
        ];
    }

    public static function defaultTwigBridgeEnabled(): array
    {
        return [
            'TwigBridge\Extension\Laravel\Event',
            'TwigBridge\Extension\Loader\Facades',
            'TwigBridge\Extension\Loader\Filters',
            'TwigBridge\Extension\Loader\Functions',
            'Juzaweb\CMS\Extension\Globals',

            //'TwigBridge\Extension\Laravel\Session',
            //'TwigBridge\Extension\Laravel\Model',
            //'TwigBridge\Extension\Laravel\Gate',

            //'TwigBridge\Extension\Laravel\Form',
            //'TwigBridge\Extension\Laravel\Html',
            //'TwigBridge\Extension\Laravel\Legacy\Facades',

            'Juzaweb\CMS\Extension\Url',
            'Juzaweb\CMS\Extension\Dump',
            'Juzaweb\CMS\Extension\Input',
            'Juzaweb\CMS\Extension\Translator',
            'Juzaweb\CMS\Extension\Str',
        ];
    }

    public static function defaultTwigFacades(): Collection
    {
        return collect(
            [
                'JWQuery' => JWQuery::class,
            ]
        );
    }
}
