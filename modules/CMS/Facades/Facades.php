<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Facades;

class Facades
{
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
}
