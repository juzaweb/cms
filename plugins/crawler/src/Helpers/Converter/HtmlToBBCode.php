<?php

namespace Juzaweb\Crawler\Helpers\Converter;

class HtmlToBBCode extends Converter
{
    protected $noneReplace = [];
    
    public function toBBCode()
    {
        $this->text = trim($this->text);

        $this->noneReplace();
        $this->replaceTabs();
        $this->replaceLinks();
        $this->replaceImgs();
        $this->replaceIframe();
    
        $this->text = str_replace("\t", "", $this->text);
        $this->text = str_replace(["<br>", "<br/>", "<br />"], "\n", $this->text);
        $this->text = strip_tags($this->text);
        $this->text = html_entity_decode($this->text, ENT_QUOTES, 'UTF-8');
        
        $this->parseNoneReplace();
        return trim($this->text);
    }
    
    protected function dom()
    {
        return str_get_html($this->text);
    }
    
    protected function noneReplace()
    {
        if (!$dom = $this->dom()) {
            return;
        }

        $preTags = $dom->find('pre');

        if ($preTags) {
            foreach ($preTags as $index => $e) {
                $this->text = str_replace(
                    $e->outertext,
                    '[none_peplace-'. $index .'][/none_peplace-'. $index .']',
                    $this->text
                );
                $this->noneReplace[$index] = $e->innertext;
            }
        }
    }
    
    protected function parseNoneReplace()
    {
        foreach ($this->noneReplace as $index => $item) {
            $this->text = str_replace(
                '[none_peplace-'. $index .'][/none_peplace-'. $index .']',
                '<pre>' . $item . '</pre>',
                $this->text
            );
        }
    
        $this->text = str_replace("<pre><code>", "<pre>", $this->text);
        $this->text = str_replace("</code></pre>", "</pre>", $this->text);
    }
    
    protected function replaceLinks()
    {
        if (!$dom = $this->dom()) {
            return;
        }

        foreach ($dom->find('a') as $e) {
            $this->text = str_replace(
                $e->outertext,
                '[url="' . $this->escUrl($e->href) . '"]'. $e->innertext .'[/url]',
                $this->text
            );
        }
    }
    
    protected function replaceImgs()
    {
        if (!$dom = $this->dom()) {
            return;
        }

        foreach ($dom->find('img') as $e) {
            $img_url = $this->escUrl($e->src);
            
            if (isset($e->{'data-src'}) && is_url($e->{'data-src'})) {
                $img_url = $e->{'data-src'};
            }
            
            if (isset($e->{'data-lazy-src'}) && is_url($e->{'data-lazy-src'})) {
                $img_url = $e->{'data-lazy-src'};
            }
    
            $this->text = str_replace(
                $e->outertext,
                '[img]'. $img_url .'[/img]',
                $this->text
            );
        }
    
        foreach ($dom->find('source[type=image/webp]') as $e) {
            if (isset($e->{'data-pin-media'})) {
                $this->text = str_replace(
                    $e->outertext,
                    '[img]'. $this->escUrl($e->{'data-pin-media'}) .'[/img]',
                    $this->text
                );
            }
        }
    }
    
    protected function replaceIframe()
    {
        if (!$dom = $this->dom()) {
            return;
        }

        foreach ($dom->find('iframe') as $e) {
            if ($e->src) {
                $this->text = str_replace(
                    $e->outertext,
                    '[embed]'. $this->escUrl($e->src) .'[/embed]',
                    $this->text
                );
            }
    
            if (@$e->{'data-src'}) {
                $this->text = str_replace(
                    $e->outertext,
                    '[embed]'. $this->escUrl($e->{'data-src'}) .'[/embed]',
                    $this->text
                );
            }
            
            if (@$e->{'data-lazy-src'}) {
                $this->text = str_replace(
                    $e->outertext,
                    '[embed]'. $this->escUrl($e->{'data-lazy-src'}) .'[/embed]',
                    $this->text
                );
            }
        }
    }
    
    protected function replaceFonts()
    {
        if (!$dom = $this->dom()) {
            return;
        }

        foreach ($dom->find('span') as $e) {
            if (!isset($e->style)) {
                continue;
            }

            $this->text = str_replace(
                $e->outertext,
                '[size=]'. trim($e->innertext) .'[/size]',
                $this->text
            );
        }
    }
    
    protected function replaceTabs()
    {
        if (!$dom = $this->dom()) {
            return;
        }

        foreach ($dom->find('p') as $e) {
            $this->text = str_replace($e->outertext, '[p]'. trim($e->innertext) .'[/p]', $this->text);
        }
    
        foreach ($dom->find('b') as $e) {
            $this->text = str_replace($e->outertext, '[b]'. trim($e->innertext) .'[/b]', $this->text);
        }
    
        foreach ($dom->find('u') as $e) {
            $this->text = str_replace($e->outertext, '[u]'. trim($e->innertext) .'[/u]', $this->text);
        }
    
        foreach ($dom->find('i') as $e) {
            $this->text = str_replace($e->outertext, '[i]'. trim($e->innertext) .'[/i]', $this->text);
        }
        
        foreach ($dom->find('ul') as $e) {
            $this->text = str_replace($e->outertext, '[ul]'. trim($e->innertext) .'[/ul]', $this->text);
        }
    
        foreach ($dom->find('ol') as $e) {
            $this->text = str_replace($e->outertext, '[ol]'. trim($e->innertext) .'[/ol]', $this->text);
        }
    
        foreach ($dom->find('li') as $e) {
            $this->text = str_replace($e->outertext, '[li]'. trim($e->innertext) .'[/li]', $this->text);
        }
    
        foreach ($dom->find('strong') as $e) {
            $this->text = str_replace($e->outertext, '[b]'. trim($e->innertext) .'[/b]', $this->text);
        }
        
        for ($i=1; $i<=6; $i++) {
            foreach ($dom->find('h' . $i) as $e) {
                $this->text = str_replace($e->outertext, '[h3]'. trim($e->innertext) .'[/h3]', $this->text);
            }
        }
    }
    
    protected function escUrl($url)
    {
        $url = trim($url);
        $url = str_replace(["\n", "\t", " "], '', $url);
        return $url;
    }
}
