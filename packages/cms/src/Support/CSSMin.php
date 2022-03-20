<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support;

class CSSMin
{
    public static function minify($css, $options = [])
    {
        $options = array_merge([
            'compress' => true,
            'removeCharsets' => true,
            'currentDir' => null,
            'docRoot' => $_SERVER['DOCUMENT_ROOT'],
            'prependRelativePath' => null,
            'symlinks' => [],
        ], $options);

        if ($options['removeCharsets']) {
            $css = preg_replace('/@charset[^;]+;\\s*/', '', $css);
        }
        if ($options['compress']) {
            $obj = new CssMinifier();
            $css = $obj->run($css);
        }
        if (! $options['currentDir'] && ! $options['prependRelativePath']) {
            return $css;
        }
        if ($options['currentDir']) {
            return UriRewriter::rewrite(
                $css,
                $options['currentDir'],
                $options['docRoot'],
                $options['symlinks']
            );
        }

        return UriRewriter::prepend(
            $css,
            $options['prependRelativePath']
        );
    }
}
