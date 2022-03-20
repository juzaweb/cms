<?php

namespace Juzaweb\Crawler\Helpers\Translate;

use Juzaweb\Crawler\Helpers\Converter\BBCodeToHtml;
use Juzaweb\Crawler\Helpers\Converter\HtmlToBBCode;

class TranslateText
{
    protected $source;
    protected $target;
    protected $text;
    protected $preview;
    protected $noneReplace = [];
    
    public function __construct($source, $target, $text, $preview = false) {
        $this->source = $source;
        $this->target = $target;
        $this->text = $text;
        $this->preview = $preview;
    }
    
    public function translateBBCode() {
        $this->noneReplace();
        
        $trans_text = $this->text;
        $texts = preg_split('|[[\/\!]*?[^\[\]]*?]|si', $trans_text, -1, PREG_SPLIT_NO_EMPTY);
        $translate = new GoogleTranslate();
        
        foreach ($texts as $index => $textrow) {
            if ($this->excludeTranslate($textrow)) {
                continue;
            }
    
            if ($this->excludeTranslate($textrow)) {
                continue;
            }
    
            $raw = [" ", "\n", "\t", "\r"];
    
            $before = '';
            $after = '';
    
            if (in_array($textrow[0], $raw)) {
                $before = $textrow[0];
            }
    
            if (in_array($textrow[-1], $raw)) {
                $after = $textrow[-1];
            }
    
            try {
                $cv_text = html_entity_decode(trim($textrow), ENT_QUOTES, 'UTF-8');
                $trans = $translate->translate($this->source, $this->target, $cv_text);
                if ($trans === false) {
                    return false;
                }
            }
            catch (\Exception $exception) {
                if ($this->preview) {
                    dd(trim($textrow), $exception->getMessage());
                }
        
                \Log::error(json_encode([trim($textrow), $exception->getMessage()]));
                return false;
            }
    
            $trans_text = preg_replace('/' . preg_quote($textrow, '/') . '/', $before . $trans . $after, $trans_text, 1);
            if (!$this->preview) {
                sleep(3);
            }
        }
        
        $this->text = $trans_text;
        $this->parseNoneReplace();
        return $this->text;
    }
    
    public function translateBBCode2() {
        try {
            $trans = new GoogleTranslate();
            $this->text = html_entity_decode($this->text);
            $texts = explode('. ', $this->text);
            $trans_text = '';
            
            foreach ($texts as $index => $textrow) {
                $textrow = str_replace(['.[', '][', '!['], ['. [', '] [', '! ['], $textrow);
                $trans_text .= $trans->translate($this->source, $this->target, $textrow);
        
                if (isset($texts[$index + 1])) {
                    $trans_text .= '. ';
                }
            }
    
            $this->text = str_replace([
                '[ ',
                '[/ mạnh]',
                ' src = ',
                '[nhúng]',
                '[/ nhúng]',
                '[/ ',
                '[p][/p]',
                '[/P]',
            ], [
                '[',
                '[/b]',
                ' src=',
                '[embed]',
                '[/embed]',
                '[/',
                '',
                '[/p]',
            ], $trans_text);
            
            $find = [
                '~\[(.*?)\]\ (.*?)\ \[\/(.*?)\]~s',
            ];
    
            $replace = [
                '[$1]$2[/$3]',
            ];
            
            $this->text = preg_replace($find, $replace, $this->text);
            
            return $this->text;
        }
        catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }
    
    public function translateHtml() {
        $trans = new GoogleTranslate();
        $this->text = html_entity_decode($this->text);
        $texts = explode('. ', $this->text);
        
        $trans_text = '';
        foreach ($texts as $index => $textrow) {
            $textrow = str_replace(['.<', '><', '!<'], ['. <', '> <', '! <'], $textrow);
            $trans_text .= $trans->translate($this->source, $this->target, $textrow);
        
            if (isset($texts[$index + 1])) {
                $trans_text .= '. ';
            }
        }
        
        $this->text = preg_replace([
            '/\.\./',
            '/\<\ /',
            '/\<\/ mạnh\>/',
            '/\ src\ \=\ /',
            '/\[nhúng\]/',
            '/\[\/ nhúng\]/'
        ], [
            '.',
            '<',
            '</strong>',
            ' src=',
            '[embed]',
            '[/embed]'
        ], $trans_text);
        
        return $this->text;
    }
    
    protected function dom() {
        return str_get_html($this->text);
    }
    
    protected function noneReplace() {
        foreach ($this->dom()->find('pre') as $index => $e) {
            $this->text = str_replace($e->outertext, '[nonepeplace'. $index .'][/nonepeplace'. $index .']', $this->text);
            $this->noneReplace[$index] = $e->innertext;
        }
    }
    
    protected function parseNoneReplace() {
        foreach ($this->noneReplace as $index => $item) {
            $this->text = str_replace('[nonepeplace'. $index .'][/nonepeplace'. $index .']', '<pre>' . $item . '</pre>', $this->text);
        }
        
        $this->text = str_replace("<pre><code>", "<pre>", $this->text);
        $this->text = str_replace("</code></pre>", "</pre>", $this->text);
    }
    
    protected function toHtml() {
        $bbcode_html = new BBCodeToHtml($this->text);
        $this->text = $bbcode_html->toHtml();
    }
    
    protected function toBBCode() {
        $html_bbcode = new HtmlToBBCode($this->text);
        $this->text = $html_bbcode->toBBCode();
    }
    
    protected function excludeTranslate($text) {
        if (empty(trim($text))) {
            return true;
        }
        
        if ($text == " ") {
            return true;
        }
        
        if (is_url($text) || is_image_path($text)) {
            return true;
        }
        
        return false;
    }
}