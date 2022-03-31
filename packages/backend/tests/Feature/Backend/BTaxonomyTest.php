<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Tests\Feature\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Facades\ActionRegister;
use Juzaweb\Models\Model;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Models\User;
use Juzaweb\Backend\Tests\TestCase;

class BTaxonomyTest extends TestCase
{
    protected $user;

    protected $postTypes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('is_admin', '=', 1)
            ->first();
        
        Auth::loginUsingId($this->user->id);

        $this->postTypes = HookAction::getPostTypes();
    }

    public function testTaxonomies()
    {
        foreach ($this->postTypes as $key => $postType) {
            $taxonomies = HookAction::getTaxonomies($key);
            if ($taxonomies->isEmpty()) {
                continue;
            }
            
            foreach ($taxonomies as $taxonomy) {
                $this->indexTest($taxonomy);

                $this->createTest($taxonomy);

                $this->updateTest($taxonomy);
            }
        }
    }

    protected function indexTest($taxonomy)
    {
        $response = $this->get($this->getUrlTaxonomy($taxonomy));

        $response->assertStatus(200);
    }

    protected function createTest($taxonomy)
    {
        $response = $this->get($this->getUrlTaxonomy($taxonomy) . '/create');

        $response->assertStatus(200);

        if ($tax = $this->makeFactory($taxonomy)) {
            $old = app(Taxonomy::class)->count();
            $this->post($this->getUrlTaxonomy($taxonomy), $tax->getAttributes());
            $new = app(Taxonomy::class)->count();
            $this->assertEquals($old, ($new - 1));
        }
    }

    protected function updateTest($taxonomy)
    {
        if ($tax = $this->makeFactory($taxonomy)) {
            $model = app(Taxonomy::class)->first(['id']);

            $response = $this->get(
                $this->getUrlTaxonomy($taxonomy) . '/' . $model->id . '/edit'
            );

            $response->assertStatus(200);

            $this->put(
                $this->getUrlTaxonomy($taxonomy) . '/' . $model->id,
                $tax->getAttributes()
            );

            $model = app(Taxonomy::class)
                ->where('id', '=', $model->id)
                ->first();

            $this->assertEquals($tax->getAttribute('name'), $model->name);
        }
    }

    /**
     *
     * @param Collection $taxonomy
     *
     * @return Model|\Illuminate\Database\Eloquent\Model|false
     */
    protected function makeFactory($taxonomy)
    {
        try {
            $post = Taxonomy::factory()->make();
            return $post;
        } catch (\Throwable $e) {
            echo "\n--- " . $e->getMessage();
        }

        return false;
    }

    protected function getUrlTaxonomy($taxonomy)
    {
        return '/admin-cp/' . str_replace(
                '.',
                '/',
                $taxonomy->get('menu_slug')
            );
    }
}
