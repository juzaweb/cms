<?php namespace Juzaweb\CMS\Support\ShortCode;

use Juzaweb\CMS\Contracts\ShortCode as ShortCodeContract;
use Juzaweb\CMS\Support\ShortCode\Compilers\ShortCodeCompiler;

class ShortCode implements ShortCodeContract
{
    /**
     * Shortcode compiler
     *
     * @var ShortCodeCompiler
     */
    protected ShortCodeCompiler $compiler;

    /**
     * Constructor
     *
     * @param ShortCodeCompiler $compiler
     */
    public function __construct(ShortCodeCompiler $compiler)
    {
        $this->compiler = $compiler;
    }

    /**
     * Register a new shortcode
     *
     * @param string $name
     * @param callable|string $callback
     *
     * @return \Juzaweb\CMS\Support\ShortCode\Shortcode
     */
    public function register(string $name, callable|string $callback): static
    {
        $this->compiler->add($name, $callback);

        return $this;
    }

    /**
     * Enable the laravel-shortcodes
     *
     * @return \Juzaweb\CMS\Support\ShortCode\Shortcode
     */
    public function enable(): static
    {
        $this->compiler->enable();

        return $this;
    }

    /**
     * Disable the laravel-shortcodes
     *
     * @return \Juzaweb\CMS\Support\ShortCode\Shortcode
     */
    public function disable(): static
    {
        $this->compiler->disable();

        return $this;
    }

    /**
     * Compile the given string
     *
     * @param  string $value
     *
     * @return string
     */
    public function compile(string $value): string
    {
        // Always enable when we call the compile method directly
        $this->enable();

        // return compiled contents
        return $this->compiler->compile($value);
    }

    /**
     * Remove all shortcode tags from the given content.
     *
     * @param string $value
     *
     * @return string
     */
    public function strip(string $value): string
    {
        return $this->compiler->strip($value);
    }
}
