<?php

namespace Juzaweb\CMS\Support;

use Illuminate\View\Compilers\BladeCompiler as BaseCompiler;

class BladeMinifyCompiler extends BaseCompiler
{
    /**
     * Compile the given Blade template contents.
     *
     * @param  string  $value
     * @return string
     */
    public function compileString($value)
    {
        $contents = parent::compileString($value);
        $contents = $this->minifyString($contents);

        return $contents;
    }

    /**
     * Minify the compiled Blade template contents.
     *
     * @param  string  $value
     * @return string
     */
    protected function minifyString($value)
    {
        return Blade::minify($value, [
            //'cssMinifier' => [CSSMin::class, 'minify'],
            'jsMinifier' => function ($contents) {
                return JSMin::minify($contents);
            },
        ]);
    }
}
