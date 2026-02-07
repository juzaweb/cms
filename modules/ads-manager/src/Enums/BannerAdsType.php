<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\AdsManagement\Enums;

enum BannerAdsType: string
{
    case TYPE_BANNER = 'image';
    case TYPE_HTML = 'html';
}
