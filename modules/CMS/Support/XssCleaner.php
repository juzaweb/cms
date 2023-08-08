<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Arr;

class XssCleaner
{
    /**
     * @var string
     */
    protected $scriptsAndIframesPattern = '/(<script.*script>|<frame.*frame>|<iframe.*iframe>|<object.*object>|<embed.*embed>)/isU';

    /**
     * @var string
     */
    protected $inlineListenersPattern = '/(\bon[A-z]+=(\"|\').*(\"|\')(?=.*>)|(javascript:.*(?=.(\'|")??>)(\)|;)??))/isU';

    /**
     * @var string
     */
    protected $invalidHtmlInlineListenersPattern = '/\bon[A-z]+=(\"|\')?.*(\"|\')?(?=.*>)/isU';

    /**
     * Clean
     *
     * @param string $value
     *
     * @return string
     */
    public function clean(string $value): string
    {
        $value = $this->escapeScriptsAndIframes($value);
        $value = config('xss-filter.escape_inline_listeners', false)
            ? $this->escapeInlineEventListeners($value)
            : $this->removeInlineEventListeners($value);

        return $value;
    }

    /**
     * Escape Scripts And Iframes
     *
     * @param string $value
     *
     * @return string
     */
    protected function escapeScriptsAndIframes(string $value): string
    {
        preg_match_all($this->scriptsAndIframesPattern, $value, $matches);

        foreach (Arr::get($matches, '0', []) as $script) {
            $value = str_replace($script, e($script), $value);
        }

        return $value;
    }

    /**
     * Remove Inline Event Listeners
     *
     * @param string $value
     *
     * @return string
     */
    protected function removeInlineEventListeners(string $value): string
    {
        $string = preg_replace($this->inlineListenersPattern, '', $value);
        $string = preg_replace($this->invalidHtmlInlineListenersPattern, '', $string);

        return ! is_string($string) ? '' : $string;
    }

    /**
     * Escape Inline Event Listeners
     *
     * @param string $value
     *
     * @return string
     */
    protected function escapeInlineEventListeners(string $value): string
    {
        $string = preg_replace_callback($this->inlineListenersPattern, [$this, 'escapeEqualSign'], $value);
        $string = preg_replace_callback($this->invalidHtmlInlineListenersPattern, [$this, 'escapeEqualSign'], $string);

        return ! is_string($string) ? '' : $string;
    }

    /**
     * Escape Equal Sign
     *
     * @param array $matches
     *
     * @return string
     */
    protected function escapeEqualSign(array $matches): string
    {
        return str_replace('=', '&#x3d;', $matches[0]);
    }
}
