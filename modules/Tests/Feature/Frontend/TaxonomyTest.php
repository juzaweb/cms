<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Frontend;

use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\Tests\TestCase;

class TaxonomyTest extends TestCase
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
