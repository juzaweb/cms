<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Tests\Feature\Frontend;

use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Backend\Tests\TestCase;

class BTestTaxonomy extends TestCase
{
    public function testTaxonomy()
    {
        $taxonomies = Taxonomy::query()->get();
        foreach ($taxonomies as $taxonomy) {
            $permalink = HookAction::getPermalinks($taxonomy);
            $base = $permalink->get('base');
    
            $response = $this->get("/{$base}/");
    
            $response->assertStatus(200);
        }
    }
}
