<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\Admin\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BANNED = 'banned';

    public static function all(): array
    {
        return [
            self::ACTIVE->value => self::ACTIVE->label(),
            self::INACTIVE->value => self::INACTIVE->label(),
            self::BANNED->value => self::BANNED->label(),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => __('core::translation.active'),
            self::INACTIVE => __('core::translation.inactive'),
            self::BANNED => __('core::translation.banned'),
        };
    }
}
