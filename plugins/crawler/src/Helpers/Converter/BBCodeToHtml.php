<?php

namespace Juzaweb\Crawler\Helpers\Converter;

class BBCodeToHtml extends Converter
{
    public function toHtml($title = '') {
        $this->replaceTabs($title);
        
        $this->text = trim($this->text);
        $this->text = str_replace("\t", "", $this->text);
        $this->text = str_replace("<br><br>", "<br>", $this->text);
        return $this->text;
    }
    
    protected function replaceTabs($title) {
        $image_url = \Storage::disk('public')->url('/');
        
        $this->text = str_replace([
            '[code][code]',
            '[/code][/code]'
        ], [
            '[code]',
            '[/code]'
        ], $this->text);
        
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
            '~\[url=\"(.*?)\"\](.*?)\[/url\]~s',
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
            '<img src="$1" alt="'. htmlspecialchars($title) .'" />',
            '<img src="'. $image_url .'$1" alt="'. htmlspecialchars($title) .'" />',
            '<div class="embed-responsive embed-responsive-16by9"><iframe src="$1" class="embed-responsive-item" allowfullscreen></iframe></div>',
            '<pre>$1</pre>',
        ];
        
        $this->text = preg_replace($find, $replace, $this->text);
    }
}