<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Converter;

use Illuminate\Support\Facades\Storage;

class BBCodeToHTML
{
    public static function toHTML(?string $text, ?string $alt = null): string
    {
        return app(static::class)->convert($text, $alt);
    }

    public function convert(?string $text, ?string $alt = ''): string|null
    {
        $text = $this->replaceTabs($text, $alt);
        $text = trim($text);
        $text = str_replace("\t", "", $text);
        return str_replace("<br><br>", "<br>", $text);
    }

    protected function replaceTabs(?string $text, ?string $alt = ''): string|null
    {
        $imageUrl = Storage::disk('public')->url('/');

        $text = str_replace(
            [
                '[code][code]',
                '[/code][/code]'
            ],
            [
                '[code]',
                '[/code]'
            ],
            $text
        );

        $find = [
            "/\n/",
            '~\[p\](.*?)\[/p\]~s',
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[h3\](.*?)\[/h3\]~s',
            '~\[ul\](.*?)\[/ul\]~s',
            '~\[ol\](.*?)\[/ol\]~s',
            '~\[li\](.*?)\[/li\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[url\](.*?)\[/url\]~s',
            '~\[url=(.*?)\](.*?)\[/url\]~s',
            '~\[img\]((https?)://.*?)\[/img\]~s',
            '~\[img\](.*?)\[/img\]~s',
            '~\[embed\](.*?)\[/embed\]~s',
            '~\[code\](.*?)\[/code\]~s',
        ];

        $replace = [
            '<br>',
            '<p>$1</p>',
            '<strong>$1</strong>',
            '<i>$1</i>',
            '<u>$1</u>',
            '<h3>$1</h3>',
            '<ul>$1</ul>',
            '<ol>$1</ol>',
            '<li>$1</li>',
            '<pre>$1</pre>',
            '<span style="font-size:$1px;">$2</span>',
            '<span style="color:$1;">$2</span>',
            '<a href="$1" rel="nofollow" target="_blank">$1</a>',
            '<a href="$1" rel="nofollow" target="_blank">$2</a>',
            '<img src="$1" alt="'. e($alt) .'" />',
            '<img src="'. $imageUrl .'$1" alt="'. e($alt) .'" />',
            '<div class="embed-responsive">'.
            '<iframe src="$1" class="embed-responsive-item" allowfullscreen></iframe>'
            .'</div>',
            '<pre>$1</pre>',
        ];

        return preg_replace($find, $replace, $text);
    }
}
