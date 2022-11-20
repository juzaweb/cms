<?php

namespace Juzaweb\Tests\Unit;

use Juzaweb\CMS\Contracts\ShortCode;
use Juzaweb\Tests\TestCase;

class ShortCodeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->shortcode = app()->make(ShortCode::class);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(\Juzaweb\CMS\Support\ShortCode\ShortCode::class, $this->shortcode);
    }

    public function testRegistrationAndCompileShortcode()
    {
        $this->shortcode->register(
            'b',
            function ($shortcode, $content) {
                return sprintf('<strong class="%s">%s</strong>', $shortcode->class, $content);
            }
        );

        $compiled = $this->shortcode->compile('[b class="bold"]Bold Text[/b]');

        $this->assertEquals('<strong class="bold">Bold Text</strong>', $compiled);
    }

    public function testStripShortcode()
    {
        $this->shortcode->register(
            'shortcode',
            function ($shortcode, $content) {
                return 'foobar';
            }
        );

        $compiled = $this->shortcode->strip('[shortcode]Text[/shortcode]');

        $this->assertEmpty($compiled);
    }
}
