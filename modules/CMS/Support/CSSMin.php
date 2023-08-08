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

class CSSMin
{
    public static function minify($css, $options = [])
    {
        $options = array_merge(
            [
                'compress' => true,
                'removeCharsets' => true,
                'currentDir' => null,
                'docRoot' => $_SERVER['DOCUMENT_ROOT'],
                'prependRelativePath' => null,
                'symlinks' => [],
            ],
            $options
        );

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
