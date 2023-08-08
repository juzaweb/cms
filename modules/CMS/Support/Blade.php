<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

class Blade extends MinifyHtml
{
    /** @var string */
    protected const BLOCK_TAGS_REGEX = 'area|article|aside|base(?:font)?|blockquote|body|'
    . 'canvas|caption|center|col(?:group)?|dd|dir|div|dl|dt|fieldset|figcaption|figure|'
    . 'footer|form|frame(?:set)?|h[1-6]|head|header|hgroup|hr|html|legend|li|link|main|'
    . 'map|menu|meta|nav|ol|opt(?:group|ion)|output|p|param|section|table|tbody|thead|'
    . 'td|th|tr|tfoot|title|ul|video';

    /** @var string */
    protected const INLINE_TAGS_REGEX = 'a|abbr|acronym|b|bdo|big|br|button|cite|dfn|em|i|'
    . 'img|input|kbd|label|map|object|q|samp|select|small|span|strong|sub|sup|time|tt|var';

    /**
     * "Minify" an Blade page
     *
     * @param string $blade
     * @param array $options
     * @return string
     */
    public static function minify($blade, $options = [])
    {
        $minifier = new self($blade, $options);

        return $minifier->process();
    }

    /**
     * Minify the markeup given in the constructor
     *
     * @return string
     */
    public function process()
    {
        if ($this->_isXhtml === null) {
            $this->_isXhtml = (false !== strpos($this->_html, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML'));
        }

        $this->_replacementHash = 'MINIFYHTML' . md5($_SERVER['REQUEST_TIME']);
        $this->_placeholders = [];

        // replace PHPs with placeholders
        $this->_html = preg_replace_callback(
            '/<\?php(\\b[^?>]*?[\\s\\S]*?\?>)/iu',
            [$this, '_removePhpCB'],
            $this->_html
        );

        // replace SCRIPTs (and minify) with placeholders
        $this->_html = preg_replace_callback(
            '/(\\s*)<script(\\b[^>]*?>)([\\s\\S]*?)<\\/script>(\\s*)/iu',
            [$this, '_removeScriptCB'],
            $this->_html
        );

        // replace STYLEs (and minify) with placeholders
        $this->_html = preg_replace_callback(
            '/\\s*<style(\\b[^>]*>)([\\s\\S]*?)<\\/style>\\s*/iu',
            [$this, '_removeStyleCB'],
            $this->_html
        );

        // remove HTML comments (not containing IE conditional comments).
        $this->_html = preg_replace_callback(
            '/<!--([\\s\\S]*?)-->/u',
            [$this, '_commentCB'],
            $this->_html
        );

        // replace PREs with placeholders
        $this->_html = preg_replace_callback(
            '/<pre(\\b[^>]*?>[\\s\\S]*?<\\/pre>)/iu',
            [$this, '_removePreCB'],
            $this->_html
        );

        // replace TEXTAREAs with placeholders
        $this->_html = preg_replace_callback(
            '/<textarea(\\b[^>]*?>[\\s\\S]*?<\\/textarea>)/iu',
            [$this, '_removeTextareaCB'],
            $this->_html
        );

        // replace NOSCRIPTs with placeholders
        $this->_html = preg_replace_callback(
            '/<noscript(\\b[^>]*?>[\\s\\S]*?<\\/noscript>)/iu',
            [$this, '_removeNoscriptCB'],
            $this->_html
        );

        // replace CODEs with placeholders
        $this->_html = preg_replace_callback(
            '/<code(\\b[^>]*?>[\\s\\S]*?<\\/code>)/iu',
            [$this, '_removeCodeCB'],
            $this->_html
        );

        // trim each line
        $this->_html = preg_replace('/\\s+/u', ' ', $this->_html);

        // trim string in inline tags
        $this->_html = preg_replace(
            '/>\\s?([^<]|(?!%' . $this->_replacementHash . '[0-9]+%)\\S+)\\s?<\\//iu',
            '>$1</',
            $this->_html
        );

        // remove ws around block/undisplayed elements
        $this->_html = preg_replace('/\\s+(<\\/?(?:' . self::BLOCK_TAGS_REGEX . ')\\b[^>]*>)/iu', '$1', $this->_html);

        // remove ws before and after a single string in tags
        $this->_html = preg_replace(
            '/<([a-zA-Z](?:[a-zA-Z-]+)?)([^>]+)?>\\s([^\\s](?:[^<]+)?)<\\/\\1>/iu',
            '<$1$2>$3</$1>',
            $this->_html
        );
        $this->_html = preg_replace(
            '/<([a-zA-Z](?:[a-zA-Z-]+)?)([^>]+)?>((?:[^<]+[^\\s])?)\\s<\\/\\1>/iu',
            '<$1$2>$3</$1>',
            $this->_html
        );

        // remove ws outside of block/undisplayed elements with placeholders
        /*        $this->_html = preg_replace(
                    '/(<\\/?(?:' . self::BLOCK_TAGS_REGEX . ')\\b[^>]*>)(?:\\s(?:\\s*))?'
                    . '(%' . $this->_replacementHash . '[0-9]+%)(?:\\s(?:\\s*))?/iu',
                    '$1$2',
                    $this->_html
                );*/

        // remove ws between block and inline tags
        $this->_html = preg_replace(
            '/(<\\/?(?:' . self::BLOCK_TAGS_REGEX . ')\\b[^>]*>)'
            . '\\s+(<\\/?(?:' . self::INLINE_TAGS_REGEX . ')\\b[^>]*>)/iu',
            '$1$2',
            $this->_html
        );

        // remove ws at the front of opening inline tags (ex. <a>hello <span>world)
        $this->_html = preg_replace(
            '/(<(?:' . self::INLINE_TAGS_REGEX . ')\\b[^>]*>)'
            . '\\s([^\\s][^<]+[\\s]?)?(<(?:' . self::INLINE_TAGS_REGEX . ')\\b[^>]*>)/iu',
            '$1$2$3',
            $this->_html
        );

        // remove ws closing adjacent inline tags (ex. </span></label>)
        $this->_html = preg_replace(
            '/(<\\/(?:' . self::INLINE_TAGS_REGEX . ')>)'
            . '\\s+(<\\/(?:' . self::INLINE_TAGS_REGEX . ')>)/iu',
            '$1$2',
            $this->_html
        );

        // fill placeholders
        $this->_html = str_replace(
            array_keys($this->_placeholders),
            array_values(array_map('trim', $this->_placeholders)),
            $this->_html
        );
        // issue 229: multi-pass to catch scripts that didn't get replaced in textareas
        $this->_html = str_replace(
            array_keys($this->_placeholders),
            array_values(array_map('trim', $this->_placeholders)),
            $this->_html
        );

        return $this->_html;
    }

    /**
     * @param $m
     * @return string
     */
    protected function _removePhpCB($m)
    {
        return $this->_reservePlace("<?php{$m[1]}");
    }

    /**
     * @param $m
     * @return string
     */
    protected function _removeCodeCB($m)
    {
        return $this->_reservePlace("<code{$m[1]}");
    }

    /**
     * @param $m
     * @return string
     */
    protected function _removeNoscriptCB($m)
    {
        return $this->_reservePlace("<noscript{$m[1]}");
    }
}
