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
        $taxonomies = HookAction::getTaxonomies();
        foreach ($taxonomies as $types) {
            foreach ($types as $key => $taxonomy) {
                $data = Taxonomy::where('taxonomy', '=', $key)
                    ->first();
                if (empty($data)) {
                    continue;
                }
    
                $permalink = HookAction::getPermalinks($key);
                $base = $permalink->get('base');
    
                $url = "/{$base}/{$data->slug}";
                $response = $this->get($url);
    
                $this->printText("Test {$url}");
                
                $response->assertStatus(200);
            }
        }
    }
}
